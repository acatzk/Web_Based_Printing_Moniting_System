<?php include 'includes/dashboard_header.php'; ?>

<div class="content" style="margin-top: 50px;">
    <div class="container-fluid">
        <div class="col-md-12 col-sm-12 col-lg-12">
          <div class="card">
              <div class="header">
                <div class="col-md-0">
                  <a href="#" class="btn btn-info pull-right btn-fill btn-sm" data-toggle="modal" data-target="#addAccount">
                    <i class="pe-7s-plus"></i> Add
                  </a>
                </div>
                <h4 class="title">History of your Printing Activities</h4>
                <p class="category">Here are all your activities</p>
                <div class="content table-responsive table-full-width" id="mytable">
                    <table  class="table table-hover table-striped" id="user_data">
                      <thead>
                          <th>ID</th>
                          <th>Firstname</th>
                          <th>Lastname</th>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Status</th>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>

  <script type="text/javascript">
        $(document).ready(function(){
              $('#add_button').click(function(){
                  $('#user_form')[0].reset();
                  $('#.modal-title').text("Add User");
                  $('#action').val("Add");
                  $('#operation').val("Add");
              });

              var dataTable = $('#user_data').DataTable({
                  "processing": true,
                  "serverSide": true,
                  "order":[],
                  "ajax": {
                      url: "user_fetch.php",
                      method: "POST"
                  },
                  "columnDefs": [
                        {
                          "target": [0, 3, 4],
                          "orderable": false,
                        },
                    ],
              });


        });
  </script>

  <script src="assets/js/bootstrap.min.js"></script>
  <script src="js/ajax/bootstrap-datepicker1.js"></script>
  <script src="js/ajax/jquery-1.10.2.min.js"></script>
  <script src="js/ajax/jquery.dataTables.min.js"></script>
  </body>
</html>
