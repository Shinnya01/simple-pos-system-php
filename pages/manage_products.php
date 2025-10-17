<?php
if (!isAdmin()) {
  echo '<div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-4">⛔ Access denied.</div>';
  exit;
}

// =================================================================
// 🐛 FIX 1: CORRECT THE FILESYSTEM PATH FOR SAVING/DELETING
// 
// If the script is at: C:\xampp\htdocs\pure_php\layout\pages\this_script.php
// And the uploads folder is at: C:\xampp\htdocs\pure_php\layout\pages\uploads
// You only need to navigate one level deep from the script's directory.
//
// OLD: $uploadDir = __DIR__ . '/../../uploads/'; // This points to C:\xampp\htdocs\pure_php\uploads (WRONG)
$uploadDir = __DIR__ . '/uploads/'; // ✅ CORRECT: This points to C:\xampp\htdocs\pure_php\layout\pages\uploads
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

// =================================================================
// 🐛 FIX 2: CORRECT THE WEB URL PATH FOR DISPLAYING
//
// The URL must match the folder structure relative to the web root (/pure_php).
//
// Helper function to get URL path for the image
function getImageUrl($fileName) {
    // OLD: return '/pure_php/uploads/' . $fileName; // (WRONG URL)
    return 'uploads/' . $fileName; // ✅ CORRECT: Matches the new file location
}

// ------------------ CREATE Product ------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_product'])) {
  $name = trim($_POST['name']);
  $price = floatval($_POST['price']);
  $imagePath = null;

  if (!empty($_FILES['image']['name'])) {
    $fileName = time() . '_' . basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
      $imagePath = getImageUrl($fileName);
    } else {
      echo '<div class="text-red-600">⚠️ Failed to upload image. (Check file permissions: ' . htmlspecialchars($uploadDir) . ')</div>';
    }
  }

  $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
  $stmt->execute([$name, $price, $imagePath]);
}

// ------------------ UPDATE Product ------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
  $id = $_POST['id'];
  $name = trim($_POST['name']);
  $price = floatval($_POST['price']);
  $imagePath = $_POST['current_image'] ?? null;

  // When updating an image
  if (!empty($_FILES['edit_image']['name'])) {
    $fileName = time() . '_' . basename($_FILES['edit_image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['edit_image']['tmp_name'], $targetFile)) {
      $imagePath = getImageUrl($fileName);

      // Delete old image if exists
      if (!empty($_POST['current_image'])) {
                // The current_image field stores the full URL path, not the filename alone.
                // We must extract the filename to delete it from the server.
                $oldFileName = basename($_POST['current_image']);
        $oldFile = $uploadDir . $oldFileName; // <- use uploadDir and the extracted filename
        if (file_exists($oldFile)) unlink($oldFile);
      }
    }
  }

  $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=? WHERE id=?");
  $stmt->execute([$name, $price, $imagePath, $id]);
}

// ------------------ DELETE Product ------------------
// When deleting a product
if (isset($_GET['delete'])) {
  $stmt = $conn->prepare("SELECT image FROM products WHERE id=?");
  $stmt->execute([$_GET['delete']]);
  $product = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($product && !empty($product['image'])) {
    $oldFile = $uploadDir . basename($product['image']); // <- Corrected deletion logic
    if (file_exists($oldFile)) unlink($oldFile);
  }

  $conn->prepare("DELETE FROM products WHERE id=?")->execute([$_GET['delete']]);
}


$products = $conn->query("SELECT * FROM products ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>


<h1 class="text-2xl font-bold text-gray-900 mb-4">🧾 Manage Products</h1>

<!-- Add New Product -->
<form method="post" enctype="multipart/form-data" class="flex flex-wrap gap-3 mb-6">
  <input type="hidden" name="new_product" value="1">
  <input type="text" name="name" placeholder="Product name" required
         class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
  <input type="number" name="price" step="0.01" placeholder="Price" required
         class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
  <input type="file" name="image" accept="image/*"
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
        <th class="px-6 py-3 bg-gray-50">Image</th>
        <th class="px-6 py-3">Name</th>
        <th class="px-6 py-3 bg-gray-50">Price</th>
        <th class="px-6 py-3">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): 
          $image = $p['image'] ?? null; 
        ?>
        <tr class="border-b border-gray-200">
          <th class="px-6 py-4 font-medium text-gray-900 bg-gray-50"><?= $p['id'] ?></th>
          <td class="px-6 py-4">
            <?php if (!empty($p['image'])): ?>
              <img src="pages/<?= htmlspecialchars($p['image']) ?>" class="w-14 h-14 object-cover rounded-lg border" alt="Product Image">
            <?php else: ?>
              <div class="w-14 h-14 flex items-center justify-center bg-gray-100 text-gray-400 rounded-lg">🖼️</div>
            <?php endif; ?>
          </td>
          <td class="px-6 py-4"><?= htmlspecialchars($p['name']) ?></td>
          <td class="px-6 py-4 bg-gray-50">₱<?= number_format($p['price'], 2) ?></td>
          <td class="px-6 py-4">
              <button 
                class="text-blue-600 hover:underline edit-btn"
                data-id="<?= $p['id'] ?>"
                data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>"
                data-price="<?= $p['price'] ?>"
                data-image="<?= htmlspecialchars($image, ENT_QUOTES) ?>">
                Edit
              </button>


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
    <form method="post" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="edit_product" value="1">
      <input type="hidden" name="id" id="editId">
      <input type="hidden" name="current_image" id="currentImage">

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

      <div>
        <label class="block text-gray-700 text-sm mb-1">Change Image (optional)</label>
        <input type="file" name="edit_image" accept="image/*"
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <img id="previewImage" src="" class="w-20 h-20 mt-2 rounded border object-cover hidden">
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
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      const name = btn.dataset.name;
      const price = btn.dataset.price;
      const image = btn.dataset.image;

      const modal = document.getElementById('editModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');

      document.getElementById('editId').value = id;
      document.getElementById('editName').value = name;
      document.getElementById('editPrice').value = price;
      document.getElementById('currentImage').value = image || '';

      const preview = document.getElementById('previewImage');
      if (image) {
        preview.src = image;
        preview.classList.remove('hidden');
      } else {
        preview.classList.add('hidden');
      }
    });
  });
});


function closeEditModal() {
  const modal = document.getElementById('editModal');
  modal.classList.add('hidden');
  document.getElementById('previewImage').classList.add('hidden');
}

</script>
