<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400&display=swap" rel="stylesheet">
    <!-- Place the first <script> tag in your HTML's <head> -->
    <script src="https://cdn.tiny.cloud/1/mkkyk1aqb6tdvt5446ukrbo13oot52fqv2y7nhwwjmflhz4k/tinymce/7/tinymce.min.js"
            referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: [
                'code',
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                // Your account includes a free trial of TinyMCE premium features
                // Try the most popular premium features until Apr 14, 2025:
                'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
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
            resize: vertical;
            height: 100px;
        }

        .form-edit-product input[type="file"] {
            border: none;
        }

        .form-edit-product label {
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

        .submit-btn {
            background-color: #2ecc71;
            color: white;
        }

        .submit-btn:hover {
            background-color: #27ae60;
            transform: scale(1.05);
        }

        .reset-btn {
            background-color: white;
            border: 1px solid #ccc;
            color: white;
            text-decoration: none; 
            background-color: #e74c3c;
        }

        .reset-btn:hover {

            transform: scale(1.05);
        }

        #previewImage {
            width: 100px;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
        <h2>Edit product</h2>
        <form method="POST" enctype="multipart/form-data" action="/inis/admin/processUpdateProduct" class="form-edit-product">
            <div class="form-container">
                <!-- Column 1 -->
                <div class="form-column">
                    <label for="edit-product-id">Product code:</label>
                    <input type="text" id="edit-product-id" name="product_code"
                           value="<?php echo htmlspecialchars($product['product_code']); ?>" readonly required>

                    <label for="edit-product-name">Product name:</label>
                    <input type="text" id="edit-product-name" name="product_name"
                           value="<?php echo htmlspecialchars($product['name']); ?>" required>

                    <label for="edit-product-quantity">Quantity:</label>
                    <input type="number" id="edit-product-quantity" name="quantity"
                           value="<?php echo htmlspecialchars($product['quantity']); ?>" min="1" required>

                    <label for="edit-product-category">Category:</label>
                    <select id="edit-product-category" name="category_id" required>
                        <?php while ($row = $categories->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <label for="edit-product-price">Price:</label>
                    <input type="number" id="edit-product-price" name="price"
                           value="<?php echo htmlspecialchars($product['price']); ?>" min="0" required>
                </div>

                <!-- Column 2 -->
                <div class="form-column">
                    <label for="edit-product-image">Image 1:</label>
                    <input type="file" id="edit-product-image" name="image" accept="image/*">
                    <?php if (!empty($product['image'])): ?>
                        <img id="previewImage" src="/public/img/<?php echo htmlspecialchars($product['image']); ?>"
                             alt="Preview 1">
                    <?php else: ?>
                        <img id="previewImage" src="#" alt="Preview 1" style="display: none;">
                    <?php endif; ?>

                    <label for="edit-product-image1">Image 2:</label>
                    <input type="file" id="edit-product-image1" name="image1" accept="image/*">
                    <?php if (!empty($product['image1'])): ?>
                        <img id="previewImage1" src="/public/img/<?php echo htmlspecialchars($product['image1']); ?>"
                             alt="Preview 2">
                    <?php else: ?>
                        <img id="previewImage1" src="#" alt="Preview 2" style="display: none;">
                    <?php endif; ?>

                    <label for="edit-product-image2">Image 3:</label>
                    <input type="file" id="edit-product-image2" name="image2" accept="image/*">
                    <?php if (!empty($product['image2'])): ?>
                        <img id="previewImage2" src="/public/img/<?php echo htmlspecialchars($product['image2']); ?>"
                             alt="Preview 3">
                    <?php else: ?>
                        <img id="previewImage2" src="#" alt="Preview 3" style="display: none;">
                    <?php endif; ?>

                    <label for="edit-product-image3">Image 4:</label>
                    <input type="file" id="edit-product-image3" name="image3" accept="image/*">
                    <?php if (!empty($product['image3'])): ?>
                        <img id="previewImage3" src="/public/img/<?php echo htmlspecialchars($product['image3']); ?>"
                             alt="Preview 4">
                    <?php else: ?>
                        <img id="previewImage3" src="#" alt="Preview 4" style="display: none;">
                    <?php endif; ?>

                    <label for="edit-product-image4">Image 5:</label>
                    <input type="file" id="edit-product-image4" name="image4" accept="image/*">
                    <?php if (!empty($product['image4'])): ?>
                        <img id="previewImage4" src="/public/img/<?php echo htmlspecialchars($product['image4']); ?>"
                             alt="Preview 5">
                    <?php else: ?>
                        <img id="previewImage4" src="#" alt="Preview 5" style="display: none;">
                    <?php endif; ?>
                </div>
            </div>
            <label for="edit-product-description">Description:</label>
            <textarea id="edit-product-description" class="mytextarea"
                      name="description"><?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>

            <div class="form-buttons">
                <button type="submit" class="btn submit-btn">Save changes</button>
                <a style ="text-decoration: none;" href="/inis/admin/products" class="btn reset-btn">Cancel</a>
            </div>
        </form>

        <!-- Message area -->
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const imageInputs = [
            {
                input: 'edit-product-image',
                preview: 'previewImage',
                src: '<?php echo "/public/img/" . htmlspecialchars($product["image"]); ?>'
            },
            {
                input: 'edit-product-image1',
                preview: 'previewImage1',
                src: '<?php echo "/public/img/" . htmlspecialchars($product["image1"]); ?>'
            },
            {
                input: 'edit-product-image2',
                preview: 'previewImage2',
                src: '<?php echo "/public/img/" . htmlspecialchars($product["image2"]); ?>'
            },
            {
                input: 'edit-product-image3',
                preview: 'previewImage3',
                src: '<?php echo "/public/img/" . htmlspecialchars($product["image3"]); ?>'
            },
            {
                input: 'edit-product-image4',
                preview: 'previewImage4',
                src: '<?php echo "/public/img/" . htmlspecialchars($product["image4"]); ?>'
            }
        ];

        imageInputs.forEach(({input, preview, src}) => {
            const inputFile = document.getElementById(input);
            const previewImg = document.getElementById(preview);

            if (src && src !== "/public/img/") {
                previewImg.src = src;
                previewImg.style.display = 'block';
            }

            inputFile.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    });

</script>
</body>
</html>