<?php include 'comm.php'; ?>

<body>
  <?php
  include '../common/include.php';
  include '../common/header.php';
  include 'inc.php';

  if (isset($_GET['idorder'])) {
    $idOrder = $_GET['idorder'];

    $sqlOrder = "SELECT * FROM orders WHERE id = '$idOrder' ";
    $queryOrder = mysqli_query($conn, $sqlOrder);
    $rowOrder = mysqli_fetch_array($queryOrder);
    $rowStatus = $rowOrder['status'];

    if ($rowStatus == 0) {
      $sqlOrder = "UPDATE orders SET `status` = 1 WHERE id = '$idOrder' ";
    } elseif ($rowStatus == 1) {
      $sqlOrder = "UPDATE orders SET `status` = 0 WHERE id = '$idOrder' ";
    }
    $query = mysqli_query($conn, $sqlOrder);
    header('location: index.php');

  } elseif (isset($_GET['deleteidorder'])) {
      $idDelte = $_GET['deleteidorder'];

      echo '<script type="text/javascript">
            if (confirm("Do you want to delete this order??")) {
                window.location.href = "delete.php?idorder=' . $idDelte . '";
            } else {
                window.location.href = "index.php";
            }
            </script>';
  }
  ?>

  <div class="main">
    <div class="main-inner">
      <div class="container">
        <div class="row">
          <div class="span12">
            <div class="widget widget-table action-table">
              <div class="widget-header"> <i class="icon-th-list"></i>
                <h3>List orders</h3>
              </div>
              <div class="widget-content">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Total Money</th>
                      <th>Total product</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th class="td-actions"> </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $count = 0;
                    $sql = "SELECT * FROM orders";
                    $query = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($query)) {
                      $count++;
                    ?>
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td> <?php echo $row['customer_name']; ?></td>
                        <td> <?php echo $row['customer_phone']; ?> </td>
                        <td> <?php echo $row['customer_email']; ?> </td>
                        <td> <?php echo "$ " . number_format($row['total_money']); ?> </td>
                        <td> <a href="detail_order.php?order_id=<?php echo $row['id']; ?>"><?php echo $row['total_products']; ?> </td></a></td>
                        <td> <?php echo $row['created_date']; ?> </td>
                        <td>
                          <?php
                          if ($row['status'] == 1) {
                            echo 'Order successfully.';
                          } else {
                            echo 'Processing...';
                          }
                          ?>
                        </td>
                        <td class="td-actions">
                          <a href="index.php?idorder=<?php echo $row['id']; ?>" class="btn btn-small btn-success">
                            <i class="icon-large icon-ok"> </i>
                          </a>
                          <a href="index.php?deleteidorder=<?php echo $row['id']; ?>" class="btn btn-danger btn-small">
                            <i class="btn-icon-only icon-remove"> </i>
                          </a>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    include '../../layouts/footer.php';
    include 'footer.php';
    ?>

</body>

</html>