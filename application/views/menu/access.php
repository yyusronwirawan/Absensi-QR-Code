<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Database</a></li>
            </ol>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Menu Access User</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php if ($this->session->flashdata('message')) : ?>
                                <script type="text/javascript">
                                    if (swal) {
                                        Swal.fire({
                                            title: 'Data Berhasil',
                                            text: "<?= $this->session->flashdata('message'); ?>",
                                            icon: 'success'
                                        });
                                    }
                                </script>
                            <?php endif; ?>

                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>

                                        <th rowspan="2">Menu</th>

                                        <?php
                                        $sqlrole = "SELECT * FROM tabel_user_role";
                                        $role = $this->db->query($sqlrole);
                                        foreach ($role->result_array() as $r) :
                                        ?>
                                            <th><?= $r['role']; ?></th>
                                        <?php endforeach; ?>
                                        <th>Sub</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sqlaccess = "SELECT * FROM user_menu ";
                                    $mrnuaccess = $this->db->query($sqlaccess);

                                    foreach ($mrnuaccess->result_array() as $m) :
                                    ?>
                                        <tr>

                                            <td class="role" id=""><span class="badge badge-danger badge-rounded"><?= $m['menu']; ?></span></td>
                                            <?php foreach ($role->result_array() as $r) :
                                            ?>

                                                <td>
                                                    <?php
                                                    $menuidd = $m['id'];
                                                    $roleidd = $r['id'];
                                                    $querycek = "SELECT * FROM user_access_menu WHERE role_id = '$roleidd' AND menu_id = '$menuidd' ";
                                                    $cek = $this->db->query($querycek)->num_rows();
                                                    ?>
                                                    <label class="switch">
                                                        <input type="checkbox" <?= $cek < 1 ? 'status="on"' : 'checked status="off"' ?> class="toggle" menu="<?= $m['id'] ?>" role="<?= $r['id'] ?>">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                            <?php endforeach; ?>
                                            <td> <button idmenu="<?= $m['id'] ?>" data-toggle="modal" data-target="#modal<?= $m['id']; ?>" class="btn-sm btn btn-secondary submenu"> <i class="flaticon-381-controls-3"></i> Sub Menu</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>







    </div>
</div>

<?php
foreach ($mrnuaccess->result_array() as $m) :
?>
    <div class="modal fade bd-example-modal-lg" id="modal<?= $m['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sub Menu access</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <table class="table table-responsive-md">
                        <thead>
                            <tr>

                                <th rowspan="2">Menu</th>

                                <?php
                                $sqlrole = "SELECT * FROM tabel_user_role";
                                $role = $this->db->query($sqlrole);
                                foreach ($role->result_array() as $r) :
                                ?>
                                    <th><?= $r['role']; ?></th>
                                <?php endforeach; ?>

                            </tr>
                        </thead>
                        <tbody id="bodytabel">
                            <?php $iddd = $m['id'];
                            $sqlsub = "SELECT * FROM user_sub_menu WHERE menu_id = '$iddd'";
                            $submenu = $this->db->query($sqlsub)->result_array();
                            foreach ($submenu as $s) :
                            ?>
                                <tr>
                                    <td><?= $s['title'] ?></td>
                                    <?php foreach ($role->result_array() as $r) :
                                    ?>
                                        <td>
                                            <?php
                                            $menuidd = $s['id'];
                                            $roleidd = $r['id'];
                                            $querycek2 = "SELECT * FROM user_access_submenu WHERE role_id = '$roleidd' AND submenu_id = '$menuidd' ";
                                            $cek2 = $this->db->query($querycek2)->num_rows();
                                            ?>
                                            <label class="switch">
                                                <input type="checkbox" <?= $cek2 < 1 ? 'status="on"' : 'checked status="off"' ?> class="toggle2 togel2" submenu="<?= $s['id'] ?>" role="<?= $r['id'] ?>">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>
<script>
    $('.toggle').click(function() {
        let role = $(this).attr('role')
        let menu = $(this).attr('menu')
        let status = $(this).attr('status')
        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>ajax/useraccess",
            data: {
                status: status,
                menuid: menu,
                roleid: role,
            },
            // dataType: 'json',
            success: function(data) {
                console.log(data);
            },
            error: function(e) {
                console.log(e)
            }
        });
    });
    $('.toggle2').click(function() {
        let role = $(this).attr('role')
        let menu = $(this).attr('submenu')
        let status = $(this).attr('status')
        console.log(`ini adalah role ${role} id submenunya ${menu} dan status di ${status} kan`)
        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>ajax/useraccesssubmenu",
            data: {
                status: status,
                submenuid: menu,
                roleid: role,
            },
            // dataType: 'json',
            success: function(data) {
                console.log(data);
            },
            error: function(e) {
                console.log(e)
            }
        });
    });
</script>