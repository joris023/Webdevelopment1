// Initial fetch of menu items
fetchMenuItems();
async function fetchMenuItems() {
    const response = await fetch('/api/menuapi');
    const data = await response.json();

    const menuItemsList = document.getElementById('menuItemsList');
    menuItemsList.innerHTML = ''; // Clear existing items

    // Populate menu items
    Object.keys(data).forEach(category => {
        const type = category === 'foods' ? 'food' : 'drink';
        data[category].forEach(item => {
            const card = document.createElement('div');
            card.classList.add('col-md-4', 'mb-4');
            card.innerHTML = `<div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">${item.name}</h5>
                                    <p class="card-text">${item.description}</p>
                                    <p class="card-text"><strong>Price:</strong> $${item.price.toFixed(2)}</p>
                                    <p class="card-text"><strong>Stock:</strong> <span id="stock-${item.id}-${type}">${item.stock}</span></p>
                                    <button class="btn btn-success btn-sm" onclick="addStock(${item.id}, '${type}')">Add 10 Stock</button>
                                    <button class="btn btn-danger btn-sm" onclick="removeItem(${item.id}, '${type}')">Remove</button>
                                </div>
                            </div>`;
            menuItemsList.appendChild(card);
        });
    });
}

async function addMenuItem() {
    const formData = new FormData();
    formData.append('type', document.getElementById('itemType').value);
    formData.append('name', document.getElementById('itemName').value);
    formData.append('description', document.getElementById('itemDescription').value);
    formData.append('price', parseFloat(document.getElementById('itemPrice').value));
    formData.append('stock', parseInt(document.getElementById('itemStock').value, 10));

    // Add the image file if provided
    const imageFile = document.getElementById('itemImage').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    try {
        const response = await fetch('/api/menuapi', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (response.ok) {
            alert('Menu item added successfully!');
            document.getElementById('addMenuItemForm').reset();
            fetchMenuItems(); // Refresh the menu items list
        } else {
            alert('Failed to add menu item: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while adding the menu item.');
    }
}

async function addStock(itemId, itemType) {
    const stockElement = document.getElementById(`stock-${itemId}-${itemType}`);
    const currentStock = parseInt(stockElement.textContent, 10);

    const newStock = currentStock + 10;

    const response = await fetch(`/api/menuapi`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: itemId, type: itemType, stock: newStock })
    });

    if (response.ok) {
        const updatedStock = await response.json();
        document.getElementById(`stock-${itemId}-${itemType}`).textContent = updatedStock.newStock;
    } else {
        alert('Failed to update stock.');
    }
}

async function removeItem(itemId, itemType) {
    const response = await fetch(`/api/menuapi`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: itemId, type: itemType })
    });

    if (response.ok) {
        alert('Item removed successfully.');
        fetchMenuItems();
    } else {
        alert('Failed to remove item.');
    }
}

// Initial fetch
fetchMenuItems();
