<?php require_once('inc/header.php'); ?>
<section class="content" style="margin-top:100px">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card border-info">
					<div class="card-header bg-info  text-white">Data List</div>
					<div class="card-body">
						<h5 class="card-title">Data Lists</h5>
						<div>
							<!-- Button trigger modal For Add Data -->
							<button type="button" id="showCreateDataForm" class="btn bg-success text-white">
								Create Data
							</button>
							<!-- Button trigger modal For Add Data -->
							<form method="post" id="exportExcelForm" action="lib/export_to_excel.php">
								<input type="submit" id="expDataToExcel" name="export" value="Export Data To Excel" class="btn bg-info text-white">
							</form>
						</div>
						<div class="msgFromBackEnd"></div>
						<div class="table-data">
							<h3 class="text-center text-success" style="margin-top:150px;">Loading...</h3>
						</div>
					</div> <!-- /.card-body -->
				</div> <!-- /.card .border-info -->
			</div> <!-- /.col-md-8 -->
		</div> <!-- /.row -->
	</div> <!-- /.container-fluid -->
</section> <!-- /.content -->

<section class="content">
	<div class="container">
		<div class="createModal">
			<!-- modal For Add Data -->
			<div class="modal fade" id="CreateDataModal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="CreateDataModalTitle">Create Form</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="cform_out">
								<div class="form_empty"></div>
								<form name="createForm" id="createFormId" action="lib/insert_data.php" method="POST" enctype="multipart/form-data">
									<div class="form-group">
										<label for="name">Name: </label>
										<input type="text" name="name" id="name" class="form-control" value="" placeholder="Enter Name:" autocomplete="off">
										<div class="name_validity"></div>
									</div> <!-- /.form-group -->
									<div class="form-group">
										<label for="roll">Roll: </label>
										<input type="number" name="roll" id="roll" class="form-control" value="" placeholder="Enter Roll Number:" autocomplete="off">
										<div class="roll_validity"></div>
									</div> <!-- /.form-group -->
									<div class="form-group">
										<label for="address">Address: </label>
										<input type="text" name="address" id="address" class="form-control" value="" placeholder="Enter Address:" autocomplete="off">
										<div class="address_validity"></div>
									</div> <!-- /.form-group -->
									<div class="form-group">
										<input type="submit" name="create" id="createData" value="Create" class="btn bg-success text-white"> <!-- /.btn .btn-success -->
										<input type="reset" class="btn bg-light text-dark" value="Clear"> <!-- /.btn .btn-default -->
										<button type="button" class="btn bg-danger text-white" data-dismiss="modal">Close</button>
									</div> <!-- /.form-group -->
								</form> <!-- /#createFormId -->
							</div> <!-- /.form_out -->
						</div>
					</div>
				</div>
			</div>
		</div> <!-- /.createModal -->
		<div class="editModal">
			<!-- modal For Add Data -->
			<div class="modal fade" id="EditDataModal" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="EditDataModalTitle">Edit Form</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="eform_out">
								<div class="form_empty"></div>
								<form name='editform' id='editformID' action='lib/update_data.php' method='PUT' enctype='multipart/form-data'>
									<input type='hidden' id='u_id' name='id' value=''>
									<div class='form-group'>
										<label for='name'>Name: </label>
										<input type='text' name='name' id='u_name' class='form-control' value='' placeholder='Enter Name:' autocomplete='off'>
										<div class='name_validity'></div>
									</div> <!-- /.form-group -->
									<div class='form-group'>
										<label for='roll'>Roll: </label>
										<input type='number' name='roll' id='u_roll' class='form-control' value='' placeholder='Enter Roll Number:' autocomplete='off'>
										<div class='roll_validity'></div>
									</div> <!-- /.form-group -->
									<div class='form-group'>
										<label for='address'>Address: </label>
										<input type='text' name='address' id='u_address' class='form-control' value='' placeholder='Enter Address:' autocomplete='off'>
										<div class=''></div>
										<div class='address_validity'></div>
									</div> <!-- /.form-group -->
									<div class='form-group'>
										<input type='submit' class='btn bg-success text-white' id='updateData' name='update' value='Update'><!-- /.btn .btn-success -->
										<input type='reset' class='btn bg-light text-dark' value='Clear'> <!-- /.btn .btn-default -->
										<button type="button" class="btn bg-danger text-white" data-dismiss="modal"> Close </button>
									</div> <!-- /.form-group -->
								</form>
							</div> <!-- /.form_out -->
						</div>
					</div>
				</div>
			</div>
		</div> <!-- /.editModal -->
	</div> <!-- /.container -->
</section> <!-- /.content -->

<section class="content">
	<div class="container">
		<div id="test"></div>
		<p id="some"></p>
	</div> <!-- /.container -->
</section> <!-- /.content -->
<?php require_once('inc/footer.php') ?>