<?php
add_action('add_meta_boxes', function() {
    add_meta_box('custom_links', 'Переопределение ссылок', function($post) {
        $links = get_post_meta($post->ID, '_custom_links', true) ?: [];
        ?>
        <div id="custom-links-wrapper">
            <?php foreach ($links as $href => $new_link) : ?>
                <div class="custom-link-row">
                    <input type="text" name="custom_links_href[]" value="<?php echo esc_attr($href); ?>" placeholder="Старая ссылка (часть URL)" style="width:45%" />
                    →
                    <input type="text" name="custom_links_new[]" value="<?php echo esc_attr($new_link); ?>" placeholder="Новая ссылка" style="width:45%" />
                </div>
            <?php endforeach; ?>
            <div class="custom-link-row">
                <input type="text" name="custom_links_href[]" placeholder="Старая ссылка (часть URL)" style="width:45%" />
                →
                <input type="text" name="custom_links_new[]" placeholder="Новая ссылка" style="width:45%" />
            </div>
        </div>
        <button type="button" onclick="addCustomLinkRow()">Добавить ещё</button>

        <script>
        function addCustomLinkRow() {
            const wrapper = document.getElementById('custom-links-wrapper');
            const newRow = document.createElement('div');
            newRow.className = 'custom-link-row';
            newRow.innerHTML = `
                <input type="text" name="custom_links_href[]" placeholder="Старая ссылка (часть URL)" style="width:45%" />
                →
                <input type="text" name="custom_links_new[]" placeholder="Новая ссылка" style="width:45%" />
            `;
            wrapper.appendChild(newRow);
        }
        </script>
        <?php
    });
});

add_action('save_post', function($post_id) {
    if (isset($_POST['custom_links_href'], $_POST['custom_links_new'])) {
        $custom_links = [];
        $hrefs = $_POST['custom_links_href'];
        $new_links = $_POST['custom_links_new'];

        foreach ($hrefs as $key => $href) {
            $href = trim($href);
            $new_link = trim($new_links[$key]);
            if (!empty($href) && !empty($new_link)) {
                $custom_links[$href] = $new_link;
            }
        }
        update_post_meta($post_id, '_custom_links', $custom_links);
    }
});
//Отвечает за редактор ссылок на странице
?>