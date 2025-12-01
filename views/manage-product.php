<?php session_start(); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PMS - Product Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff;
            color: #000;
        }

        .navbar,
        .modal-header {
            background: #000;
            color: #fff;
        }

        .btn-dark,
        .table-dark {
            background: #000 !important;
            color: #fff !important;
        }

        .btn-outline-dark {
            border-color: #000 !important;
            color: #000 !important;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar px-3">
        <span class="navbar-brand text-white">PMS Dashboard</span>
    </nav>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="container mt-4">

        <!-- Header + Create Button -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Products</h3>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createModal">+ Add Product</button>
        </div>

        <!-- Products Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price ($)</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $productsFile = __DIR__ . '/../data/products.json';
                $products = [];
                if (file_exists($productsFile)) {
                    $json = file_get_contents($productsFile);
                    $products = json_decode($json, true);
                }

                if (!empty($products)) {
                    foreach ($products as $product) {

                        echo '<tr>';
                        echo '<td><img src="../uploads/' . htmlspecialchars($product['image']) . '" width="60"></td>';
                        echo '<td>' . htmlspecialchars($product['name']) . '</td>';
                        echo '<td>' . number_format($product['price'], 2) . '</td>';
                        echo '<td>
                
                                <!-- Edit Button -->
                                <button 
                                    class="btn btn-outline-dark btn-sm editBtn"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal"
                                    data-id="' . $product['id'] . '"
                                    data-name="' . htmlspecialchars($product['name']) . '"
                                    data-price="' . $product['price'] . '"
                                    data-image="' . $product['image'] . '"
                                >
                                    Edit
                                </button>
                
                                <!-- Delete Button -->
                                <button 
                                    class="btn btn-dark btn-sm deleteBtn"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal"
                                    data-id="' . $product['id'] . '"
                                >
                                    Delete
                                </button>
                
                            </td>';

                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">No products found.</td></tr>';
                }

                ?>

            </tbody>
        </table>
    </div>



    <!-- ==================== CREATE PRODUCT MODAL ==================== -->
    <div class="modal fade" id="createModal">
        <div class="modal-dialog">
            <form class="modal-content" action="../handlers/products_manage.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">

                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control mb-3" required>

                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control mb-3" required>

                    <label class="form-label">Image</label>
                    <input type="file" name="image" accept=".png, .jpg, .jpeg" class="form-control" required>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark" name="action" value="create">Create</button>
                </div>
            </form>
        </div>
    </div>



    <!-- ==================== EDIT PRODUCT MODAL ==================== -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" enctype="multipart/form-data" action="../handlers/products_manage.php">
                <input type="hidden" name="action" value="edit">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id">

                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control mb-3">

                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control mb-3">

                    <label class="form-label">Replace Image (optional)</label>
                    <input type="file" name="image" accept=".png, .jpg, .jpeg" class="form-control">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-dark" name="action" value="update">Update</button>
                </div>
            </form>
        </div>
    </div>



    <!-- ==================== DELETE PRODUCT MODAL ==================== -->
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="../handlers/products_manage.php">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                    <input type="hidden" name="id" value="">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-dark" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-dark" name="action" value="delete" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const editButtons = document.querySelectorAll(".editBtn");
        const editModal = document.getElementById("editModal");

        editButtons.forEach(btn => {
            btn.addEventListener("click", () => {

                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const price = btn.dataset.price;

                editModal.querySelector("input[name='id']").value = id;
                editModal.querySelector("input[name='name']").value = name;
                editModal.querySelector("input[name='price']").value = price;
            });
        });

    });
</script>


<script>
document.addEventListener("DOMContentLoaded", () => {

    // Edit buttons
    const editButtons = document.querySelectorAll(".editBtn");
    const editModal = document.getElementById("editModal");

    editButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id || '';
            const name = btn.dataset.name || '';
            const price = btn.dataset.price || '';
            const image = btn.dataset.image || '';

            editModal.querySelector("input[name='id']").value = id;
            editModal.querySelector("input[name='name']").value = name;
            editModal.querySelector("input[name='price']").value = price;

            // show current image preview (optional)
            let preview = editModal.querySelector(".current-image-preview");
            if (!preview) {
                preview = document.createElement('div');
                preview.className = 'current-image-preview mb-2';
                editModal.querySelector(".modal-body").insertBefore(preview, editModal.querySelector("input[name='image']"));
            }
            preview.innerHTML = image
                ? '<label class="form-label">Current Image</label><br><img src=\"../uploads/' + image + '\" width=\"120\" class=\"mb-2\">'
                : '';
        });
    });

    // Delete buttons
    const deleteButtons = document.querySelectorAll(".deleteBtn");
    const deleteModal = document.getElementById("deleteModal");

    deleteButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id || '';
            deleteModal.querySelector("input[name='id']").value = id;
        });
    });

});
</script>


</html>