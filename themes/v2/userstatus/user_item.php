<?php
if (!empty($useronline)) {
    foreach ($useronline as $k => $v) {
        ?>
        <?php
        //if (!empty($userstatus[$v['userid']]['vtime']) && ($userstatus[$v['userid']]['vtime'] > time()) && ($userstatus[$v['userid']]['status'] == '1')) {
        //    continue;
        //}
        ?>

        <li id="u_<?php echo $v['userid'] ?>" uid="" rid="" name="<?php echo $v['name'] ?>" ip="undefined" <?php if ($v['role'] == '1') echo 'style="display: none;" class="manager"'; ?>>
            <span>
                <?php if ($v['role'] == '1') {
                    if ($v['level'] == '0') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/1gly.png" title="房间管理员">
                    <?php } else if ($v['level'] == '1') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/6lszl.png" title="老师助理">
                    <?php } else if ($v['level'] == '2') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/7khjl.png" title="客服经理">
                    <?php } else if ($v['level'] == '4') { ?>
                        <img class="roleimg" src="/themes/v2/images/visitorlist_icon_member2.png" title="讲师">
                    <?php } else { ?>
                        <img class="roleimg" src="/themes/v2/images/visitorlist_icon_member2.png" title="客服">
                    <?php } ?>
                <?php } else if ($v['role'] == '0') {
                    if ($v['level'] == '0' || $v['level'] == '8') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/15hy.png" title="普通会员">
                    <?php } else if ($v['level'] == '1') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/14byVIP.png" title="白银VIP">
                    <?php } else if ($v['level'] == '2') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/13hjVIP.png" title="黄金VIP">
                    <?php } else if ($v['level'] == '3') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/12bjVIP.png" title="铂金会员">
                    <?php } else if ($v['level'] == '4') { ?>
                        <img class="roleimg" src="/themes/v2/static/images/14byVIP.png" title="钻石会员">
                    <?php } elseif ($v['level'] == 5) { ?>
                        <img class="roleimg" src="/themes/v2/static/images/10zzVIP.png" title="至尊会员">
                    <?php } elseif ($v['level'] == 6) { ?>
                        <img class="roleimg" src="/themes/v2/static/images/9cz.png" title="财主会员">
                    <?php } elseif ($v['level'] == 7) { ?>
                        <img class="roleimg" src="/themes/v2/static/images/8th.png" title="土豪会员">
            <?php } ?>
        <?php } else if ($v['role'] == '-1') { ?>
                    <img class="roleimg" src="/themes/v2/static/images/17yk.png" title="游客">
        <?php } ?>

            </span>		<a href="javascript:void(0)" class="f_left" ondblclick="javascript:$('#sendMsgInput').val('@'+$(this).html()+': ');"><?php echo $v['name'] ?></a>
        </li>

    <?php } ?>
<?php } ?>

<?php 
if (!empty($moniuser)) {
    foreach ($moniuser as $k => $v) {
?>
    <li id="" uid="" rid="" name="游客<?php echo $v ?>" ip="undefined">		<span>
            <img class="roleimg" src="/themes/v2/static/images/17yk.png" title="游客"></span>
        <a href="javascript:void(0)" class="f_left" ondblclick="javascript:$('#sendMsgInput').val('@'+$(this).html()+': ');">游客<?php echo $v ?></a>
    </li>
<?php 
    }
}
?>
<script>
    $("#usertotal").html(<?php echo count($useronline) + count($moniuser) + 1000 ?>);
</script>