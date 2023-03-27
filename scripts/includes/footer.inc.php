<?php if ($page == 'study') : ?>
    <script src="./assets/js/script.js"></script>
<?php endif; ?>

<?php foreach ($custom_js as $js) : ?>
    <script src="<?= $js ?>"></script>
<?php endforeach; ?>

<script src="./assets/prism/prism.js"></script>
<script src="./assets/js/general.js"></script>
</body>

</html>