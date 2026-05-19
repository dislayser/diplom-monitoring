<div class="modal fade" id="modal_delete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal-label">Внимание</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Вы действительно хотите удалить заказ(ID 1273)?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Отмена</button>
                <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">

                    <?php
                        echo fieldToken();
                        echo ui_input_hidden('id', 0);
                    ?>
                    <button type="submit" class="btn btn-danger" name="delete">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>