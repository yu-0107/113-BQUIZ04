<div class="ct"><button>新增管理員</button></div>
<!-- table.all>(tr.tt.ct>td*3)+(tr.pp.ct>td*3) -->
<table class="all">
    <tr class="tt ct">
        <td>帳號</td>
        <td>密碼</td>
        <td>管理</td>
    </tr>
    <?php
    $rows=$Admin->all();
    foreach($rows as $row):
    ?>
    <tr class="pp ct">
        <td><?=$row['acc'];?></td>
        <td><?=str_repeat("*",strlen($row['pw']));?></td>
        <td>
            <?php
            if($row['acc']=='admin'):
                echo "此帳號為最高權限";
            else:
            ?>
            <button>刪除</button>
            <button>修改</button>
            <?php
            endif;
            ?>
        </td>
    </tr>
    <?php
    endforeach;
    ?>
</table>