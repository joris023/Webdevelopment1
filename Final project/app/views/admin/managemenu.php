<?php require __DIR__ . '/../shared/header.php'; ?>
<title>Manage Menu</title>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Menu</h1>    
        <!-- Add Menu Item Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Add Menu Item</h5>
                <form id="addMenuItemForm">
                    <div class="form-group">
                        <label for="itemType">Type</label>
                        <select class="form-control" id="itemType" name="type" required>
                            <option value="food">Food</option>
                            <option value="drink">Drink</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="itemName">Name</label>
                        <input type="text" class="form-control" id="itemName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="itemDescription">Description</label>
                        <textarea class="form-control" id="itemDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="itemPrice">Price</label>
                        <input type="number" step="0.01" class="form-control" id="itemPrice" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="itemStock">Stock</label>
                        <input type="number" class="form-control" id="itemStock" name="stock" required>
                    </div>
                    <div class="form-group" enctype="multipart/form-data">
                        <label for="itemImage">Upload Image:</label>
                        <input type="file" id="itemImage" name="image" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="addMenuItem()">Add Item</button>
                </form>
            </div>
        </div>
        <h5 class="mb-3">Menu Items</h5>
        <div id="menuItemsList" class="row">
            
        </div>
    </div>
<script src="/scripts/managemenu.js"></script>
<?php require __DIR__ . '/../shared/footer.php'; ?>
