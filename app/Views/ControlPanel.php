<!-- Панель управления для мониторинга -->
<div class="offcanvas offcanvas-start w-auto shadow-lg" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="control_panel" aria-labelledby="control_panel_label">

    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title me-2" id="control_panel_label">Панель управления</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
    </div>

    <div class="offcanvas-body">
        <ul class="nav nav-pills flex-column mb-auto gap-3">
            <div class="w-100" style="height: 70px">
                <label class="form-label">Градация</label>
                <div class="rounded rainbow-gradation" id="rainbow">
                </div>
                <div class="d-flex justify-content-between">
                    <b><small data-num="start">-</small></b>
                    <b><small data-num="end">-</small></b>
                </div>
            </div>

            <div>
                <?php
                if (!isset($_COOKIE['gas_type'])){
                    set_Cookie('gas_type', null);
                }

                if (!isset($_COOKIE['sector_opacity'])){
                    set_Cookie('sector_opacity', 0.3);
                } 

                if (!isset($_COOKIE['device'])){
                    $user_device = $DB->select_one('devices', ['id_user' => $_SESSION['id']])->data;
                    if (isset($user_device['id'])){
                        set_Cookie('device', $user_device['id']);
                    }else{
                        set_Cookie('device', null);
                    }
                }
                //print_r($_COOKIE);
                $params = [];
                $devices = $DB->select('devices', $params)->data;
                xss($devices);
                ?>
                <label class="form-label" for="device">Устройство<?=$red_star?></label>
                <select class="form-select" name="device" id="device" required>
                    <option value="">Выберите устройство</option>
                    <?php foreach($devices as $device):?>
                        <option value="<?=$device['id']?>" <?=$device['id'] == get_Cookie('device') ? 'selected' : '';?>><?=$device['name']?></option>
                    <?php endforeach?>
                </select>
            </div>

            <div>
                <label class="form-label" for="gas_types">Тип газа</label>
                <select class="form-select" name="gas_types" id="gas_types" required>
                    <option value="">Выберите газ</option>
                </select>
            </div>

            <div>
                <label class="form-label" for="sector_opacity">Прозрачность секторов</label>
                <input type="range" name="sector_opacity" id="sector_opacity" class="form-range" value="<?=get_Cookie('sector_opacity')?>"  min="0" max="0.9" step="0.1">
            </div>

            <div>
                <label class="form-label" for="sector_type">Тип сектора</label>
                <select class="form-select" name="sector_type" id="sector_type" required>
                    <option value="square">Квадрат</option>
                    <option value="smooth">Сглаживание</option>
                </select>
            </div>

            <!--div>
                <label class="form-label">Размер сектора</label>
                <div class="btn-group w-100" role="group" aria-label="Размер сектора">
                    <input type="radio" class="btn-check" name="sector_size" value="1" id="sector_size-x1">
                    <label class="btn btn-outline-secondary" for="sector_size-x1">x1</label>

                    <input type="radio" class="btn-check" name="sector_size" value="2" id="sector_size-x2" checked>
                    <label class="btn btn-outline-secondary" for="sector_size-x2">x2</label>

                    <input type="radio" class="btn-check" name="sector_size" value="3" id="sector_size-x3">
                    <label class="btn btn-outline-secondary" for="sector_size-x3">x3</label>
                </div>
            </div-->

            <div>
                <input type="checkbox" class="form-check-input" value="1" id="set_mesh">
                <label for="set_mesh">Включить сетку</label>
            </div>
        </ul>
    </div>

    <!-- Sidebar footer -->
    <div  class="px-3 pb-3">
        <hr>
        <button type="button" class="btn btn-success w-100" id="cp_save" data-bs-dismiss="offcanvas" aria-label="Сохранить"><span class="spinner-border spinner-border-sm me-2" aria-hidden="true" style="display:none;"></span>Сохранить</button>
    </div>
</div>