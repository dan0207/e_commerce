<?php
    include "../../assets/cdn/cdn_links.php";
    include "../../render/connection.php";

    session_start();
    if (!isset($_SESSION['admin_email'])) {
        header("Location: ../index.php"); // Redirect to the index if not logged in
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: Bookings</title>
        
        <link rel="stylesheet" href="../../assets/style/admin_style.css">
        <link rel="icon" href="/e_commerce/assets/image/hfa_logo.png" type="image/png">

        <style>
            #downloadCsvButtonBooking, #downloadCsvButton {
                background-color:rgb(24, 180, 219); /* Blue */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadExcelButtonBooking, #downloadExcelButton {
                background-color:rgb(42, 196, 78); /* Green */
                color: white;
                border-radius: 0.25rem;
            }
            #downloadPdfButtonBooking, #downloadPdfButton {
                background-color:rgb(207, 83, 96) !important; /* Red */
                color: white;
                border-radius: 0.25rem;
            }
        </style>

    </head>

    <body>
        <div id="admin-body" class="">
            <div class="row">
                <div class="col-lg-2">
                    <?php include "../../navigation/admin_nav.php"; ?>
                </div>
                <div class="col-lg-10">
                    <?php include "../../navigation/admin_header.php"; ?>
                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Booked</h3>
                    <section class="my-2 px-4">
                        <table id="table_booking" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Scheduled Date</td>
                                    <td>Scheduled Time</td>
                                    <td>Type of Booking</td>
                                    <td>Total Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM booked";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $formattedDate = date("F j, Y", strtotime($row['date'])); // Month Day, Year
                                            $formattedTime = date("g:i A", strtotime($row['time']));  // 12-hour format with AM/PM
                                            ?>
                                            <tr>
                                                <td>
                                                <button class="bg-success border-0 p-1 text-light" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#accept_booking_<?php echo $row["id"]; ?>">
                                                        Accept
                                                    </button>
                                                    <button class="bg-danger border-0 p-1 text-light" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#decline_booking_<?php echo $row["id"]; ?>">
                                                        Decline
                                                    </button>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $formattedDate; ?></td>
                                                <td><?php echo $formattedTime; ?></td>
                                                <td><?php echo $row['type_of_booking']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Bookings</h3>
                    <section class="my-2 px-4">
                    <table id="table_booked" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Scheduled Date</td>
                                    <td>Scheduled Time</td>
                                    <td>Type of Booking</td>
                                    <td>Total Amount</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM booking";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $formattedDate = date("F j, Y", strtotime($row['date'])); // Month Day, Year
                                            $formattedTime = date("g:i A", strtotime($row['time']));  // 12-hour format with AM/PM
                                            ?>
                                            <tr>
                                                <td>
                                                    <button class="bg-success border-0 p-1 text-light" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#finish_booking_<?php echo $row["id"]; ?>">
                                                        Finish
                                                    </button>
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $formattedDate; ?></td>
                                                <td><?php echo $formattedTime; ?></td>
                                                <td><?php echo $row['type_of_booking']; ?></td>
                                                <td><?php echo $row['price']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>

                    <h3 class="p-3 text-center"><i class="fa-solid fa-book"></i> Transaction History</h3>
                    <section class="my-2 px-4">
                    <table id="table_transaction_history" class="table table-sm nowrap table-striped compact table-hover" >
                            <thead class="table-danger">
                                <tr>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Address</td>
                                    <td>Contact Number</td>
                                    <td>Scheduled Date</td>
                                    <td>Scheduled Time</td>
                                    <td>Type of Booking</td>
                                    <td>Total Amount</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM transaction_history";
                                    $result = mysqli_query($conn, $sql);

                                    if($result) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $formattedDate = date("F j, Y", strtotime($row['transaction_date'])); // Month Day, Year
                                            $formattedTime = date("g:i A", strtotime($row['time']));  // 12-hour format with AM/PM
                                            ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><?php echo $row['contact_number']; ?></td>
                                                <td><?php echo $formattedDate; ?></td>
                                                <td><?php echo $formattedTime; ?></td>
                                                <td><?php echo $row['type_of_booking']; ?></td>
                                                <td><?php echo $row['total_amount']; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>


        <script src="../../assets/script/admin_script.js"></script>

        <script>
            $(document).ready(function () {
                var table_booking = $('#table_booking').DataTable({
                    scrollX: true,
                    autoWidth: false
                });

                var table_booked = $('#table_booked').DataTable({
                    scrollX: true,
                    autoWidth: false
                });

                var currentDate = new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }); // Format: January 1, 2025

                var table_transaction_history = $('#table_transaction_history').DataTable({
                    dom: 'Bfrtip', // Required for buttons to display
                    buttons: [
                        {
                            extend: 'csv',
                            title: `Booking History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadCsvButtonBooking'); // Set unique ID for CSV button
                                $(node).addClass('btn btn-primary rounded'); // Blue button for CSV
                            },
                        },
                        {
                            extend: 'excel',
                            title: `Booking History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadExcelButtonBooking'); // Set unique ID for Excel button
                                $(node).addClass('btn btn-success rounded'); // Green button for Excel
                            },
                        },
                        {
                            extend: 'pdf',
                            title: `Booking History - ${currentDate}`,
                            init: function(api, node, config) {
                                $(node).attr('id', 'downloadPdfButtonBooking'); // Set unique ID for PDF button
                                $(node).addClass('btn btn-danger rounded'); // Red button for PDF
                            },
                            orientation: 'landscape', // Horizontal layout
                            pageSize: 'A4', // Page size
                            customize: function (doc) {
                                doc.styles.tableHeader = {
                                    bold: true,
                                    fontSize: 12,
                                    color: 'black',
                                    alignment: 'center'
                                };
                            }
                        }
                    ],
                    autoWidth: false, // Prevent automatic width calculation
                    initComplete: function () {
                        var tableWidth = this.api().table().node().offsetWidth;
                        var containerWidth = $(this.api().table().container()).parent().width();
                        if (tableWidth > containerWidth) {
                            this.api().settings()[0].oScroll.sX = '100%';
                            this.api().draw();
                        }
                    }
                });

                // Append buttons to the container
                table_transaction_history.buttons().container()
                    .appendTo('#table_transaction_history_wrapper .col-md-6:eq(0)');

            });
        </script>
    </body>
</html>