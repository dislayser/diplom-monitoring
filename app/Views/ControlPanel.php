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
                <div id="gradation" class="rounded">
                </div>
                <div class="d-flex justify-content-between">
                    <b><small data-num="start">-</small></b>
                    <b><small data-num="end">-</small></b>
                </div>
            </div>

            <div>
                <?php
                $gas_type = null;
                if (isset($_COOKIE['gas_type'])){
                    $gas_type = $_COOKIE['gas_type'];
                } 

                $sector_opacity = 0.3;
                if (isset($_COOKIE['sector_opacity'])){
                    $sector_opacity = $_COOKIE['sector_opacity'];
                } 

                if (isset($_COOKIE['device'])){
                    $user_device_id = $_COOKIE['device'];
                }else{
                    $user_device = $DB->select_one('devices', ['id_user' => $_SESSION['id']])->data;
                    if (isset($user_device['id'])){
                        $user_device_id = $user_device['id'];
                    }else{
                        $user_device_id = null;
                    }
                }
                
                $params = [];
                $devices = $DB->select('devices', $params)->data;
                xss($devices);
                ?>
                <label class="form-label" for="device">Устройство<?=$red_star?></label>
                <select class="form-select" name="device" id="device" required>
                    <option value="">Выберите устройство</option>
                    <?php foreach($devices as $device):?>
                        <option value="<?=$device['id']?>" <?=$device['id'] == $user_device_id ? 'selected' : '';?>><?=$device['name']?></option>
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
                <input type="range" name="sector_opacity" id="sector_opacity" class="form-range" value="<?=$sector_opacity?>"  min="0" max="0.9" step="0.1">
            </div>
        </ul>
    </div>

    <!-- Sidebar footer -->
    <div  class="px-3 pb-3">
        <hr>
        <button type="button" class="btn btn-success w-100" data-bs-dismiss="offcanvas" aria-label="Сохранить">Сохранить</button>
    </div>
</div>