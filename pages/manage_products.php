<?php
if (!isAdmin()) {
    echo "<h3>⛔ Access denied.</h3>";
    exit;
}

// ✅ CREATE Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_product'])) {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
    $stmt->execute([$name, $price]);
}

// ✅ UPDATE Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stmt = $conn->prepare("UPDATE products SET name=?, price=? WHERE id=?");
    $stmt->execute([$name, $price, $id]);
}

// ✅ DELETE Product
if (isset($_GET['delete'])) {
    $conn->prepare("DELETE FROM products WHERE id=?")->execute([$_GET['delete']]);
}

$products = $conn->query("SELECT * FROM products ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>🧾 Manage Products</h1>

<!-- Add New Product -->
<form method="post" class="inline-form">
    <input type="hidden" name="new_product" value="1">
    <input type="text" name="name" placeholder="Product name" required>
    <input type="number" name="price" step="0.01" placeholder="Price" required>
    <button type="submit">Add</button>
</form>

<!-- Product List -->
<table>
    <tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr>
    <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td>₱<?= number_format($p['price'], 2) ?></td>
            <td>
                <!-- Edit Button -->
                <button onclick="openEditModal(<?= $p['id'] ?>, '<?= htmlspecialchars($p['name']) ?>', <?= $p['price'] ?>)">Edit</button>
                <!-- Delete Button -->
                <a href="?page=manage_products&delete=<?= $p['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Edit Modal -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <h3>Edit Product</h3>
    <form method="post">
      <input type="hidden" name="edit_product" value="1">
      <input type="hidden" name="id" id="editId">
      <input type="text" name="name" id="editName" placeholder="Name" required>
      <input type="number" name="price" id="editPrice" step="0.01" placeholder="Price" required>
      <div class="actions">
        <button type="submit">Save</button>
        <button type="button" onclick="closeEditModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditModal(id, name, price) {
  document.getElementById('editModal').style.display = 'flex';
  document.getElementById('editId').value = id;
  document.getElementById('editName').value = name;
  document.getElementById('editPrice').value = price;
}
function closeEditModal() {
  document.getElementById('editModal').style.display = 'none';
}
</script>
