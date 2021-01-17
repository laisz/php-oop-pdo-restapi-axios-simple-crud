		<footer class="footer">
			<div class="container">
				<p class="text-center"> &copy; All Rights Reserved by Dark-Room Developer Group <?php echo date('Y'); ?></p>
			</div> <!-- /.container -->
		</footer> <!-- /.footer -->
			<!-- JQuery 3.3.1 -->
		<script src="<?php echo BASE_URL; ?>/js/3.3.1_jquery.min.js"></script>
			<!-- Material BootStrap 4 JS File -->
		<script src="<?php echo BASE_URL; ?>/boot_material_design_4/popper.js"></script>
		<script src="<?php echo BASE_URL; ?>/boot_material_design_4/bootstrap-material-design.js"></script>
		<script> $(document).ready(function() { $('body').bootstrapMaterialDesign(); }); </script>
		<script src="<?php echo BASE_URL; ?>/js/bootstrap4_datatables.min.js"></script>
		<script src="<?php echo BASE_URL; ?>/js/sweetalert2@9.js"></script>
		<script src="<?php echo BASE_URL; ?>/js/axios/axios.min.js"></script>
		<script src="<?php echo BASE_URL; ?>/script/Validation.js"></script>
		<script src="<?php echo BASE_URL; ?>/script/custom_script.js"></script> <!-- Script For Ajax -->
	</body>
</html>

<?php $db->connectionClose(); // Closing the PDO Connections HERE  ?>
