<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="<?php echo asset('js/bootstrap/popper.min.js'); ?>"></script>
    <!-- Bootstrap js -->
    <script src="<?php echo asset('js/jquery/jquery-2.2.4.min.js'); ?>"></script>
    <script src="<?php echo asset('js/bootstrap/bootstrap.min.js'); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('/css/dashboard.css'); ?>">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        $(document).ready(function() {
            var trigger = $('.hamburger'),
                overlay = $('.overlay'),
                isClosed = false;

            trigger.click(function() {
                hamburger_cross();
            });

            function hamburger_cross() {

                if (isClosed == true) {
                    overlay.hide();
                    trigger.removeClass('is-open');
                    trigger.addClass('is-closed');
                    isClosed = false;
                } else {
                    overlay.show();
                    trigger.removeClass('is-closed');
                    trigger.addClass('is-open');
                    isClosed = true;
                }
            }

            $('[data-toggle="offcanvas"]').click(function() {
                $('#wrapper').toggleClass('toggled');
            });
        });
    </script>

</head>

<body>


    <div id="wrapper">
        <div class="overlay"></div>

        <!-- Sidebar -->
        <nav class="navbar navbar-inverse fixed-top" id="sidebar-wrapper" role="navigation">
            <ul class="nav sidebar-nav">
                <div class="sidebar-header">
                    <div class="sidebar-brand">
                        <a href="#">Admin</a>
                    </div>
                </div>
                <li><a href="/#home">Home</a></li>
                <li><a href="/dashboard?table=user#events">User</a></li>
                <li><a href="/dashboard?table=cong+thuc#events">Công Thức</a></li>
                <li><a href="/dashboard?table=the+loai#events">Thể Loại</a></li>
                <li><a href="/dashboard?table=danh+gia#events">Đánh Giá</a></li>
            </ul>
        </nav>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <button type="button" class="hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
                <span class="hamb-middle"></span>
                <span class="hamb-bottom"></span>
            </button>
            <div class="container">
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header pb-3 d-flex align-items-center justify-content-center">
                                    <h6 id="name-table" >Bảng Công Thức</h6>
                                </div>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        </th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        </th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        </th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        </th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        </th>
                                                    <th class="text-secondary opacity-7"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table">
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div>
                                                                <img src=""
                                                                    class="avatar avatar-sm me-3" alt="user1">
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">John Michael</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    john@creative-tim.com</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit
                                                            amet
                                                            consectetur adipisicing elit. Ad sapiente facilis inventore
                                                            ullam
                                                            molestiae ut hic explicabo. Ipsa vitae recusandae aliquam
                                                            illo,
                                                            inventore perspiciatis ullam voluptas voluptates sit?
                                                            Cumque, quaerat.
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit
                                                            amet
                                                            consectetur adipisicing elit. Ad sapiente facilis inventore
                                                            ullam
                                                            molestiae ut hic explicabo. Ipsa vitae recusandae aliquam
                                                            illo,
                                                            inventore perspiciatis ullam voluptas voluptates sit?
                                                            Cumque, quaerat.
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit
                                                            amet
                                                            consectetur adipisicing elit. Ad sapiente facilis inventore
                                                            ullam
                                                            molestiae ut hic explicabo. Ipsa vitae recusandae aliquam
                                                            illo,
                                                            inventore perspiciatis ullam voluptas voluptates sit?
                                                            Cumque, quaerat.
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit
                                                            amet
                                                            consectetur adipisicing elit. Ad sapiente facilis inventore
                                                            ullam
                                                            molestiae ut hic explicabo. Ipsa vitae recusandae aliquam
                                                            illo,
                                                            inventore perspiciatis ullam voluptas voluptates sit?
                                                            Cumque, quaerat.
                                                        </p>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="javascript:;"
                                                            class="text-secondary font-weight-bold text-xs"
                                                            data-toggle="tooltip" data-original-title="Edit user">
                                                            Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->




    {{-- <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center justify-content-center">
                        <h6>Bảng Đánh Giá</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tác Giả</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Mã Công Thức</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nội Dung</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ngày Đăng</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody id="table-dg">
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3"
                                                        alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">John Michael</h6>
                                                    <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit amet
                                                consectetur adipisicing elit. Ad sapiente facilis inventore ullam
                                                molestiae ut hic explicabo. Ipsa vitae recusandae aliquam illo,
                                                inventore perspiciatis ullam voluptas voluptates sit? Cumque, quaerat.
                                            </p>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-secondary text-xs ">Lorem ipsum dolor, sit amet
                                                consectetur adipisicing elit. Error perferendis, vel quae, porro eaque
                                                officia praesentium voluptatum cum adipisci quas earum ad iusto?
                                                Maiores, debitis delectus beatae officiis excepturi et!
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias quasi
                                                nihil unde ratione esse? Sapiente aperiam laudantium cumque porro earum
                                                non odio repellendus iste eos, quod delectus, eius, similique
                                                beatae!</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-3 d-flex align-items-center justify-content-center">
                        <h6>Bảng Thể Loại</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tên Thể Loại</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Mô Tả</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Đường dẫn ảnh</th>

                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody id="table-tl">
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit amet
                                                consectetur adipisicing elit. Ad sapiente facilis inventore ullam
                                                molestiae ut hic explicabo. Ipsa vitae recusandae aliquam illo,
                                                inventore perspiciatis ullam voluptas voluptates sit? Cumque, quaerat.
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit amet
                                                consectetur adipisicing elit. Ad sapiente facilis inventore ullam
                                                molestiae ut hic explicabo. Ipsa vitae recusandae aliquam illo,
                                                inventore perspiciatis ullam voluptas voluptates sit? Cumque, quaerat.
                                            </p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <p class="text-xs font-weight-bold mb-0">Lorem ipsum dolor sit amet
                                                consectetur adipisicing elit. Ad sapiente facilis inventore ullam
                                                molestiae ut hic explicabo. Ipsa vitae recusandae aliquam illo,
                                                inventore perspiciatis ullam voluptas voluptates sit? Cumque, quaerat.
                                            </p>
                                        </td>
                                        <td class="align-middle">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


</body>

</html>
