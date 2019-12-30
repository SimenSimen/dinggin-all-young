<?php require_once('include_footer.php') ?>

<?php require_once('_modal.php') ?>

<script async src="<?= base_url('js/bundle.js') ?>"></script>

<?php $this->load->view($indexViewPath . '/include_ajax_handler'); ?>
<?php $this->load->view($indexViewPath . '/include_ajax_cart'); ?>
<?php $this->load->view($indexViewPath . '/include_ajax_filter'); ?>
</body>

</html>