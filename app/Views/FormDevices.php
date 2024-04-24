<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Наименование</label>
            <input type="text" class="form-control" name="name" requred>
        </div>
        <div class="com-md-4">
            <label class="form-label">Статус</label>
            <select name="status" id="status">
                <?php foreach($device_statuses as $item):?>
                    <option value="<?=$item['id']?>"><?=$item['name']?></option>
                <?php endforeach;?>
            </select>
            <input type="text" class="form-control" name="name" requred>
        </div>
    </div>
</form>