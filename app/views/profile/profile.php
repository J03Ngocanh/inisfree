<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Tab color */
        .nav-tabs .nav-link {
            font-size: 18px;
            color: #28a745;
            border: 1px solid #28a745;
            border-radius: 8px;
        }

        .nav-tabs .nav-link.active {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }

        .tab-content {
            padding: 20px;
            border: 1px solid #28a745;
            border-top: none;
            border-radius: 0 0 12px 12px;
        }

        h3 {
            color: #28a745;
            font-weight: bold;
        }

        /* Order history table */
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background: #28a745;
            color: white;
        }

        .table tbody tr:hover {
            background: #e9f5ea;
        }

        .table th, .table td {
            padding: 12px;
            text-align: center;
            font-size: 16px;
        }
    </style>
</head>
<body>


<div class="container mt-5">
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button"
                    role="tab">Personal info
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button"
                    role="tab">Order history
            </button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content mt-3" id="myTabContent">
        <!-- Personal info -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <h3>Personal Info</h3>
            <?php if (isset($info1))  { ?>
            <?php while ($row = mysqli_fetch_array($info1)) { ?>
                <p><strong>Name:</strong><?php echo $row['name'] ?> </p>
                <p><strong>Email:</strong><?php echo $row['email'] ?></p>
                <p><strong>Phone:</strong> <?php echo $row['phone'] ?></p>
                <p><strong>Date of birth:</strong> <?php echo $row['date_of_birth'] ?></p>
                <p><strong>Points:</strong> <?php echo $row['point'] ?></p>
                <p><strong>Member rank:</strong> <?php echo $row['name'] ?></p>
            <?php } ?>
            <?php } ?>
        </div>

        <!-- Order history -->
        <div class="tab-pane fade" id="history" role="tabpanel">
            <h3>Order History</h3>
            <?php if (!empty($history)) { ?>
                <?php foreach ($history as $orderId => $orderData) { ?>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orderData['items'] as $item) { ?>
                            <tr>
                                <td><?php echo $orderId; ?></td>
                                <td><?php echo $orderData['created_at']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $orderData['total']; ?></td>
                                <td><?php echo $orderData['status']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
