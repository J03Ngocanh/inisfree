<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Add Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
    <style>
        h2 {
            text-align: center;
            color: #2ecc71;
            margin-bottom: 20px;
        }

        .main-content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .form-column {
            width: 48%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-add-product input,
        .form-add-product select,
        .form-add-product textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-add-product textarea {
            resize: vertical;
            height: 100px;
        }

        .form-add-product input[type="file"] {
            border: none;
        }

        .form-add-product label {
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left;
        }

        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .form-buttons .btn {
            min-width: 120px;
            height: 50px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .submit-btn:hover {
            background-color: #388E3C;
        }

        .reset-btn {
            background-color: #f44336;
            color: white;
            text-decoration: none; 
        }

        .reset-btn:hover {
            background-color: #d32f2f;
        }

        #previewImage {
            width: 100px;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            display: none;
        }

        @media (max-width: 768px) {
            .form-column {
                width: 100%;
            }

            .form-buttons {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
<div class="detail">
    <div class="main-content">
        <div class="main-content">
            <h2>Add new product</h2>
            <form method="POST" enctype="multipart/form-data" action="/inis/admin/processAddProduct"
                  class="form-add-product">
                <div class="form-container">
                    <!-- Column 1 -->
                    <div class="form-column">
                        <label for="add-product-name">Product name:</label>
                        <input type="text" id="add-product-name" name="product_name" required>

                        <label for="add-product-quantity">Quantity:</label>
                        <input type="number" id="add-product-quantity" name="quantity" min="1" required>

                        <label for="add-product-category">Category:</label>
                        <select id="add-product-category" name="category_id" required>
                            <?php while ($row = $categories->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <label for="add-product-image">Image 1:</label>
                        <input type="file" id="add-product-image" name="image" accept="image/*" required>
                        <img id="previewImage" src="#" alt="Preview 1">
                    </div>

                    <!-- Column 2 -->
                    <div class="form-column">
                        <label for="add-product-description">Product description:</label>
                        <textarea id="add-product-description" name="description"></textarea>

                        <label for="add-product-price">Product price:</label>
                        <input type="number" id="add-product-price" name="price" min="0" required>

                        <label for="add-product-image1">Image 2:</label>
                        <input type="file" id="add-product-image1" name="image1" accept="image/*">
                        <img id="previewImage1" src="#" alt="Preview 2">

                        <label for="add-product-image2">Image 3:</label>
                        <input type="file" id="add-product-image2" name="image2" accept="image/*">
                        <img id="previewImage2" src="#" alt="Preview 3">

                        <label for="add-product-image3">Image 4:</label>
                        <input type="file" id="add-product-image3" name="image3" accept="image/*">
                        <img id="previewImage3" src="#" alt="Preview 4">

                        <label for="add-product-image4">Image 5:</label>
                        <input type="file" id="add-product-image4" name="image4" accept="image/*">
                        <img id="previewImage4" src="#" alt="Preview 5">
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn submit-btn">Add product</button>
                    <a href="/inis/admin/products" class="btn reset-btn">Cancel</a>
                </div>
            </form>

            <?php
            if (isset($_SESSION['success_message'])) {
                echo "<script>alert('" . addslashes($_SESSION['success_message']) . "');</script>";
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error'])) {
                echo "<script>alert('" . addslashes($_SESSION['error']) . "');</script>";
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
    <script>
        // Image preview for 5 fields
        const imageInputs = [
            {input: 'add-product-image', preview: 'previewImage'},
            {input: 'add-product-image1', preview: 'previewImage1'},
            {input: 'add-product-image2', preview: 'previewImage2'},
            {input: 'add-product-image3', preview: 'previewImage3'},
            {input: 'add-product-image4', preview: 'previewImage4'}
        ];

        imageInputs.forEach(({input, preview}) => {
            document.getElementById(input).addEventListener('change', function (e) {
                const file = e.target.files[0];
                const previewImg = document.getElementById(preview);
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>
</html>