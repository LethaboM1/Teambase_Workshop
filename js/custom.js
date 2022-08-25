/* Add here all your JS customizations */

function ajax_ ($data, $result, $type='post') {
    $data.ajax({
        method: $type,
        url:'includes/ajax.php',
        data: $data,
        success(result) {
            $('#' + $result).html(result);
        }
    });
}