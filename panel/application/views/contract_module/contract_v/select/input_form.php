<table class="table">
    <tbody>
    <tr>
        <td>
            <select id="select2-demo-1" class="form-control col-sm-12"
                    required data-plugin="select2" name="proje_id">
                <option value=""></option>
                <?php foreach ($active_projects as $active_project) { ?>
                    <option value="<?php echo $active_project->id; ?>"><?php echo $active_project->project_name; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>
            <small class="pull-left input-form-error"> Sadece aktif durumda olan işler
                listelenir. Projenizi listede bulamıyorsanız Projeler listesi üzerinde
                ilgili işi "Devam Ediyor" olarak değiştirmeniz gerekmektedir.</small>
        </td>
    </tr>
    </tbody>
</table>