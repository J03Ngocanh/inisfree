<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/fu913pcqvkkjh88a0sbfv2ujw5rgt3bh3w46uhb7drzy233p/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.mytextarea',
            plugins: [
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                // Your account includes a free trial of TinyMCE premium features
                // Try the most popular premium features until Dec 16, 2024:
                'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown',
                // Early access to document converters
                'importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                {value: 'First.Name', title: 'First Name'},
                {value: 'Email', title: 'Email'},
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),

        });

    </script>


    <style>
        h2 {
            text-align: center;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .main-content header {
            background-color: #1abc9c;
            padding: 20px;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .content-section {
            display: none;
        }

        .content-section:not(.hidden) {
            display: block;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        td {
            color: #333;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Hiệu ứng modal */
        .modal {
            display: flex;
            position: fixed;
            z-index: 1000;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%); /* Dịch chuyển về chính giữa */
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 20px;
        }

        /* Cấu trúc modal dạng ngang */
        .modal-content {
            background-color: white;
            width: 80vw; /* Rộng 80% màn hình */
            max-width: 1000px; /* Giới hạn chiều rộng tối đa */
            padding: 20px;
            border-radius: 10px;
            max-height: 85vh; /* Chiếm tối đa 85% chiều cao màn hình */
            overflow-y: auto; /* Cuộn nếu nội dung quá dài */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            font-family: Arial, sans-serif;
        }

        /* Header modal */
        .modal-content h2 {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2ecc71;
        }

        /* Định dạng 2 cột cho form */
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        /* Mỗi cột chiếm 48% chiều rộng */
        .form-column {
            width: 48%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Input, select, textarea */
        .form-edit-product input,
        .form-edit-product select,
        .form-edit-product textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-edit-product textarea {
            resize: none;
            height: 100px;
        }

        /* Input file */
        .form-edit-product input[type="file"] {
            border: none;
        }

        /* Close modal button */
        .close {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 24px;
            cursor: pointer;
            border: none;
            background: none;
            color: #555;
        }

        .close:hover {
            color: red;
        }

        /* Điều chỉnh kích thước modal trên màn hình nhỏ */
        @media (max-width: 600px) {
            .modal-content {
                width: 95vw; /* Chiếm 95% chiều rộng màn hình nhỏ */
                max-width: none; /* Không giới hạn */
                max-height: 95vh;
            }
        }

        /* Căn chỉnh form bên trong popup */
        .form-edit-product {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Label */
        .form-edit-product label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            text-align: left;
        }

        /* Căn chỉnh nút */
        .form-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 20px;
        }

        .form-buttons .btn {
            min-width: 120px;
            height: 50px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 10px; /* Bo góc nhẹ */
            display: flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        /* Add product button */
        .submit-btn {
            background-color: #1abc9c;
            color: white;
        }

        .submit-btn:hover {
            background-color: #16a085;
            transform: scale(1.05);
        }

        /* Cancel button */
        .reset-btn {
            background-color: white;
            border: 1px solid #ccc;
            color: black;
            text-decoration: none; 

        }

        .reset-btn:hover {
            background-color: #e74c3c;
            color: white;
            transform: scale(1.05);
            cursor: pointer;
        }

        /* Điều chỉnh modal trên màn hình nhỏ */
        @media (max-width: 768px) {
            .modal-content {
                width: 95vw; /* Giữ kích thước phù hợp */
                max-width: none;
                max-height: 90vh;
            }

            .form-container {
                flex-direction: column;
            }

            .form-column {
                width: 100%; /* Mỗi cột chiếm toàn bộ chiều rộng */
            }

            .form-buttons {
                flex-direction: column;
                gap: 10px;
            }

        }

        #previewImage {
            width: 100px; /* Giữ kích thước vừa phải */
            height: auto;
            margin-left: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Hide modal by default */
        #productModal {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        /* Show modal when active */
        #productModal.show {
            visibility: visible;
            opacity: 1;
        }

        #editProductModal {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        /* Show modal when active */
        #editProductModal.show {
            visibility: visible;
            opacity: 1;
        }

        /* Button base */
        a button {
            padding: 8px 12px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        /* Edit button */
        a .edit-btn {
            background-color: #3498db;
            color: white;
        }

        a .edit-btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        /* Delete button */
        a .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        a .delete-btn:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .add-btn {
            background-color: #2ecc71;
            color: white;
            font-weight: bold;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #2ecc71;
            color: white;
            font-weight: bold;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-actions h2 {
            margin: 0;
            font-size: 24px;
        }

        .header-actions .submit-btn {
            margin: 0;
        }

        .edit-icon, .delete-icon {
            font-size: 18px;
            cursor: pointer;
            margin: 0 8px;
            transition: transform 0.2s ease-in-out;
        }

        .edit-icon {
            color: #3498db;
        }

        .delete-icon {
            color: #e74c3c;
        }

        .edit-icon:hover {
            transform: scale(1.2);
            color: #2980b9;
        }

        .delete-icon:hover {
            transform: scale(1.2);
            color: #c0392b;
        }

        .add-btn {
            background-color: #4CAF50;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 8px 10px 10px 10px;
            position: fixed;
            top: 70px;
            right: 20px;
            border-radius: 10px;
            border: solid white;
            z-index: 1000;
            cursor: pointer;
        }

        a .submit-btn:hover {
            background-color: #27ae60;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        th:nth-child(7),
        td:nth-child(7) {
            width: 100px;
            max-width: 100px;
        }


    </style>
</head>
<body>
<div class="detail">
    <h2>Product List</h2>
    <!-- Open popup button -->
    <button class="add-btn" onclick="window.location.href='/inis/admin/addProduct'">Add product</button>
    <!-- Modal (Popup) -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add new product</h2>
            <form method="POST" enctype="multipart/form-data" action="/inis/admin/processAddProduct"
                  class="form-edit-product">
                <div class="form-container">
                    <!-- Cột 1 -->
                    <div class="form-column">

                        <label for="product-name">Product name:</label>
                        <input type="text" id="product_name" name="product_name" required>

                        <label for="product-quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="" min="1" required>

                        <label for="product-category">Category:</label>
                        <select name="category_id" id="product-category">
                            <?php while ($row = $categories->fetch_assoc()): ?>
                                <option value="<?= $row['category_id'] ?>"><?= $row['tendanhmuc'] ?></option>
                            <?php endwhile; ?>
                        </select>

                    </div>

                    <!-- Cột 2 -->
                    <div class="form-column">
                        <label for="product-description">Description:</label>
                        <textarea id="description" name="description"></textarea>

                        <label for="product-price">Price:</label>
                        <input type="number" id="price" name="price" value="" min="0" required>

                        <label for="product-image">Select image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                        <img id="previewImage" src="#" alt="Preview" style="display: none;">
                    </div>
                </div>

                <!-- Form buttons -->
                <div class="form-buttons">
                    <button type="submit" class="btn submit-btn">Add product</button>
                    <button type="reset" class="btn reset-btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <table>
        <thead>
        <tr>

            <th>Product code</th>
            <th>Product name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tbody>
        <?php while ($row = mysqli_fetch_array($productList)): ?>
            <tr>
                <td><?php echo $row['product_code']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><img style="width:100px" src="<?php echo WEBROOT . 'public/img/' . $row['image']; ?>" alt=""></td>
                <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>

                <!-- Highlight if quantity below 20 -->
                <td class="<?= ($row['quantity'] < 20) ? 'low-stock' : ''; ?>">
                    <?php echo $row['quantity']; ?>
                <td>    <?php if ($row['quantity'] < 20): ?>
                        <span class="warning-text">⚠️ Low stock!</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="/inis/admin/editProduct/<?php echo $row['product_code']; ?>">
                        <i class="fa-solid fa-pen-to-square edit-icon"></i>
                    </a>
                    <a href="/inis/admin/deleteProduct/<?php echo $row['product_code']; ?>"
                       onclick="return confirmCustom('Are you sure you want to delete this product?')">
                        <i class="fa-solid fa-trash delete-icon"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>

    </table>
    <!-- Edit product modal -->

</div>

<?php
if (isset($_SESSION['success_message'])) {
    echo "<script>alert('" . addslashes($_SESSION['success_message']) . "');</script>";
    unset($_SESSION['success_message']);
}
?>
</div>


<script>
    function confirmCustom(message) {
        const isConfirmed = window.confirm(message);
        return isConfirmed;
    }
</script>
<script>
    // Open modal
    function openModal() {
        document.getElementById("productModal").classList.add('show');
    }

    // Close modal
    function closeModal() {
        document.getElementById("productModal").classList.remove('show');
    }

    // Close modal on outside click
    window.onclick = function (event) {
        const modal = document.getElementById("productModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.getElementById('product-image');
        const formResetButton = document.querySelector('.form-edit-product .reset-btn');
        const previewImage = document.querySelector("#products img");
        const previewImageContainer = document.createElement('div');

        // Add preview container
        previewImageContainer.style.marginTop = '10px';
        previewImageContainer.innerHTML = '<img id="preview-image" style="width: 500px; display: none; border: 1px solid #ccc; border-radius: 5px;" />';
        fileInput.insertAdjacentElement('afterend', previewImageContainer);

        const previewImage = document.getElementById('preview-image');

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];

            // Check if no file
            if (!file) {
                previewImage.style.display = 'none';
                return;
            }

            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file!');
                fileInput.value = '';
                previewImage.style.display = 'none';
                return;
            }

            // Check file size
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must not exceed 2MB!');
                fileInput.value = '';
                previewImage.style.display = 'none';
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });

        // Reset ảnh xem trước khi nhấn nút làm mới
        formResetButton.addEventListener('click', () => {
            previewImage.style.display = 'none';
            fileInput.value = '';
        })
    });
</script>

</body>
</html>

