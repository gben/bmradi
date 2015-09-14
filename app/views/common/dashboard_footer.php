<!-- Footer -->
<footer>
    <div class="row">
        <div class="col-lg-12">
            <p>Copyright &copy; Your Website 2014</p>
        </div>
    </div>
</footer>

</div>
<!-- /.container -->

<!-- jQuery Version 1.11.0 -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script type="text/javascript" src="<?php echo url(); ?>/media/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
   


    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste moxiemanager"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
</script>

<script src="<?php echo url(); ?>/media/js/jquery-2.1.1.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo url(); ?>/media/js/bootstrap.js"></script>

</body>
</html>