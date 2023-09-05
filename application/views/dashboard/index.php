<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-primary">
                            <h5 class="font-weight-bold text-uppercase">Earnings (Monthly)</h5>
                            <h1 class="text-gray-800">$40,000</h1>
                        </div>
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-success">
                            <h5 class="font-weight-bold text-uppercase">Earnings (Annual)</h5>
                            <h1 class="text-gray-800">$215,000</h1>
                        </div>
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-info">
                            <h5 class="font-weight-bold text-uppercase">Tasks</h5>
                            <div class="progress mt-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-warning">
                            <h5 class="font-weight-bold text-uppercase">Pending Requests</h5>
                            <h1 class="text-gray-800">18</h1>
                        </div>
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header">
                    <strong>User Sedang Login</strong>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Nama:</label>
                        <input type="text" class="form-control" id="inputName" value="<?= userdata('name'); ?>"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputUsername">Username:</label>
                        <input type="text" class="form-control" id="inputUsername" value="<?= userdata('username'); ?>"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputRole">Role:</label>
                        <input type="text" class="form-control" id="inputRole" value="<?= userdata('role'); ?>"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="inputLoginTime">Jam Login:</label>
                        <input type="text" class="form-control" id="inputLoginTime"
                            value="<?= $this->session->userdata('login_session')['log']; ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>