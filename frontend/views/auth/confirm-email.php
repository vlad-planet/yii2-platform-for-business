<?php
/** @var $result bool */
?>

<?php if (true === $result): ?>
    <h3>
        Спасибо за подтверждение электронного адреса! <br> Через 5 секунд, Вы будете перенаправлены на главную страницу
    </h3>
    <script>
        setTimeout(() => window.location.href = '/', 5000)
    </script>
<?php else : ?>
    <h1>Упс! Что-то пошло не так. :(</h1>
<?php endif; ?>