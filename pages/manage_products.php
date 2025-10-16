<?php
if (!isAdmin()) {
    echo '<div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-4">⛔ Access denied.</div>';
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


<h1 class="text-2xl font-bold text-gray-900 mb-4">🧾 Manage Products</h1>

<!-- Add New Product -->
<form method="post" class="flex flex-wrap gap-3 mb-6">
  <input type="hidden" name="new_product" value="1">
  <input type="text" name="name" placeholder="Product name" required
         class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
  <input type="number" name="price" step="0.01" placeholder="Price" required
         class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
  <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
    ➕ Add
  </button>
</form>

<!-- Product Table -->
<div class="overflow-x-auto shadow rounded-lg border border-gray-200">
  <table class="w-full text-sm text-left text-gray-700">
    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
      <tr>
        <th class="px-6 py-3">ID</th>
        <th class="px-6 py-3 bg-gray-50">Name</th>
        <th class="px-6 py-3">Price</th>
        <th class="px-6 py-3 bg-gray-50">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr class="border-b border-gray-200">
          <th class="px-6 py-4 font-medium text-gray-900 bg-gray-50"><?= $p['id'] ?></th>
          <td class="px-6 py-4"><?= htmlspecialchars($p['name']) ?></td>
          <td class="px-6 py-4 bg-gray-50">₱<?= number_format($p['price'], 2) ?></td>
          <td class="px-6 py-4">
            <button onclick="openEditModal(<?= $p['id'] ?>, '<?= htmlspecialchars($p['name']) ?>', <?= $p['price'] ?>)"
                    class="text-blue-600 hover:underline">Edit</button>
            <a href="?page=manage_products&delete=<?= $p['id'] ?>" 
               onclick="return confirm('Delete this product?')" 
               class="text-red-500 hover:underline ml-2">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-40 z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
    <h3 class="text-xl font-semibold mb-4">✏️ Edit Product</h3>
    <form method="post" class="space-y-4">
      <input type="hidden" name="edit_product" value="1">
      <input type="hidden" name="id" id="editId">
      
      <div>
        <label class="block text-gray-700 text-sm mb-1">Name</label>
        <input type="text" name="name" id="editName" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>

      <div>
        <label class="block text-gray-700 text-sm mb-1">Price</label>
        <input type="number" name="price" id="editPrice" step="0.01" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>

      <div class="flex justify-end gap-3">
        <button type="button" onclick="closeEditModal()" 
          class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">Cancel</button>
        <button type="submit" 
          class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditModal(id, name, price) {
  document.getElementById('editModal').classList.remove('hidden');
  document.getElementById('editModal').classList.add('flex');
  document.getElementById('editId').value = id;
  document.getElementById('editName').value = name;
  document.getElementById('editPrice').value = price;
}
function closeEditModal() {
  document.getElementById('editModal').classList.add('hidden');
}
</script>
