<?php
    include('../../config.php');

    header('Content-type:text/html;charset=utf-8');

    $name = $_GET['store_name'];

    $sql = "SELECT * FROM Store WHERE name='$name'";
    $result = mysqli_query($conn, $sql) or print_sql_error_and_die($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $category = $row['category'];
    $region = $row['region'];
    $type1 = $row['type1'];
    $type2 = $row['type2'];
    $property = $row['property'];
    $property_show = $row['property_show'];
 ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    </head>
    <body>
        <form action="store_modify_preview.php" method="post">
            name: <input type="text" name="name" value="<?php echo($name) ?>"/><br>

            category:
            <input type="checkbox" name="category[]" value="0" <?php if(($category & pow(2,0)) != 0) echo('checked') ?>/>밥
            <input type="checkbox" name="category[]" value="1" <?php if(($category & pow(2,1)) != 0) echo('checked') ?>/>카페
            <input type="checkbox" name="category[]" value="2" <?php if(($category & pow(2,2)) != 0) echo('checked') ?>/>술<br>

            region:
            <input type="checkbox" name="region[]" value="0" <?php if(($region & pow(2,0)) != 0) echo('checked') ?>/>참살이
            <input type="checkbox" name="region[]" value="1" <?php if(($region & pow(2,1)) != 0) echo('checked') ?>/>정대후문
            <input type="checkbox" name="region[]" value="2" <?php if(($region & pow(2,2)) != 0) echo('checked') ?>/>이공후문
            <input type="checkbox" name="region[]" value="3" <?php if(($region & pow(2,3)) != 0) echo('checked') ?>/>교내
            <input type="checkbox" name="region[]" value="4" <?php if(($region & pow(2,4)) != 0) echo('checked') ?>/>정문
            <input type="checkbox" name="region[]" value="5" <?php if(($region & pow(2,5)) != 0) echo('checked') ?>/>법대후문
            <input type="checkbox" name="region[]" value="6" <?php if(($region & pow(2,6)) != 0) echo('checked') ?>/>제기동
            <input type="checkbox" name="region[]" value="7" <?php if(($region & pow(2,7)) != 0) echo('checked') ?>/>고려대역<br>

            type1:<br>
            <input type="checkbox" name="type1[]" value="0" <?php if(($type1 & pow(2,0)) != 0) echo('checked') ?>/>한식
            <input type="checkbox" name="type1[]" value="1" <?php if(($type1 & pow(2,1)) != 0) echo('checked') ?>/>중식
            <input type="checkbox" name="type1[]" value="2" <?php if(($type1 & pow(2,2)) != 0) echo('checked') ?>/>일식
            <input type="checkbox" name="type1[]" value="3" <?php if(($type1 & pow(2,3)) != 0) echo('checked') ?>/>양식
            <input type="checkbox" name="type1[]" value="4" <?php if(($type1 & pow(2,4)) != 0) echo('checked') ?>/>치킨
            <input type="checkbox" name="type1[]" value="5" <?php if(($type1 & pow(2,5)) != 0) echo('checked') ?>/>고기
            <input type="checkbox" name="type1[]" value="6" <?php if(($type1 & pow(2,6)) != 0) echo('checked') ?>/>분식
            <input type="checkbox" name="type1[]" value="7" <?php if(($type1 & pow(2,7)) != 0) echo('checked') ?>/>기타<br>

            <input type="checkbox" name="type1[]" value="8" <?php if(($type1 & pow(2,8)) != 0) echo('checked') ?>/>소주
            <input type="checkbox" name="type1[]" value="9" <?php if(($type1 & pow(2,9)) != 0) echo('checked') ?>/>맥주
            <input type="checkbox" name="type1[]" value="10" <?php if(($type1 & pow(2,10)) != 0) echo('checked') ?>/>막걸리
            <input type="checkbox" name="type1[]" value="11" <?php if(($type1 & pow(2,11)) != 0) echo('checked') ?>/>양주
            <input type="checkbox" name="type1[]" value="12" <?php if(($type1 & pow(2,12)) != 0) echo('checked') ?>/>와인
            <input type="checkbox" name="type1[]" value="13" <?php if(($type1 & pow(2,13)) != 0) echo('checked') ?>/>사케<br>

            <input type="checkbox" name="type1[]" value="16" <?php if(($type1 & pow(2,16)) != 0) echo('checked') ?>/>커피
            <input type="checkbox" name="type1[]" value="17" <?php if(($type1 & pow(2,17)) != 0) echo('checked') ?>/>브런치
            <input type="checkbox" name="type1[]" value="18" <?php if(($type1 & pow(2,18)) != 0) echo('checked') ?>/>빙과
            <input type="checkbox" name="type1[]" value="19" <?php if(($type1 & pow(2,19)) != 0) echo('checked') ?>/>주스
            <input type="checkbox" name="type1[]" value="20" <?php if(($type1 & pow(2,20)) != 0) echo('checked') ?>/>차
            <input type="checkbox" name="type1[]" value="21" <?php if(($type1 & pow(2,21)) != 0) echo('checked') ?>/>제과<br>

            type2:<br>
            <input type="checkbox" name="type2[]" value="0" <?php if(($type2 & pow(2,0)) != 0) echo('checked') ?>/>부담없게
            <input type="checkbox" name="type2[]" value="1" <?php if(($type2 & pow(2,1)) != 0) echo('checked') ?>/>무난보통
            <input type="checkbox" name="type2[]" value="2" <?php if(($type2 & pow(2,2)) != 0) echo('checked') ?>/>작은사치<br>

            <input type="checkbox" name="type2[]" value="8" <?php if(($type2 & pow(2,8)) != 0) echo('checked') ?>/>조용조용
            <input type="checkbox" name="type2[]" value="9" <?php if(($type2 & pow(2,9)) != 0) echo('checked') ?>/>무난보통
            <input type="checkbox" name="type2[]" value="10" <?php if(($type2 & pow(2,10)) != 0) echo('checked') ?>/>시끌시끌<br>

            <input type="checkbox" name="type2[]" value="16" <?php if(($type2 & pow(2,16)) != 0) echo('checked') ?>/>테이크아웃
            <input type="checkbox" name="type2[]" value="17" <?php if(($type2 & pow(2,17)) != 0) echo('checked') ?>/>조용히할일
            <input type="checkbox" name="type2[]" value="18" <?php if(($type2 & pow(2,18)) != 0) echo('checked') ?>/>대화와만남<br>

            img: <input <?php if(!isset($_GET["store_name"])) echo("disabled") ?> type="text" name="img" size="100" value="<?php echo($row['img']) ?>"/><br>
            owner_comment: <input type="text" name="owner_comment" size="100" value="<?php echo($row['owner_comment']) ?>"/><br>
            contact: <input type="text" name="contact" size="100" value="<?php echo($row['contact']) ?>"/><br>
            store_hours: <textarea name="store_hours" rows="5" cols="100"><?php echo($row['store_hours']) ?></textarea><br>

            property:<br>
            <input type="checkbox" name="property[]" value="0" <?php if(($property & pow(2,0)) != 0) echo('checked') ?>/>배달
            <input type="checkbox" name="property[]" value="1" <?php if(($property & pow(2,1)) != 0) echo('checked') ?>/>포장
            <input type="checkbox" name="property[]" value="3" <?php if(($property & pow(2,3)) != 0) echo('checked') ?>/>예약(밥)<br>
            <input type="checkbox" name="property[]" value="9" <?php if(($property & pow(2,9)) != 0) echo('checked') ?>/>예약(술)
            <input type="checkbox" name="property[]" value="4" <?php if(($property & pow(2,4)) != 0) echo('checked') ?>/>대관
            <input type="checkbox" name="property[]" value="5" <?php if(($property & pow(2,5)) != 0) echo('checked') ?>/>단체석(술)<br>
            <input type="checkbox" name="property[]" value="6" <?php if(($property & pow(2,6)) != 0) echo('checked') ?>/>좌식
            <input type="checkbox" name="property[]" value="7" <?php if(($property & pow(2,7)) != 0) echo('checked') ?>/>흡연실
            <input type="checkbox" name="property[]" value="8" <?php if(($property & pow(2,8)) != 0) echo('checked') ?>/>1인석
            <input type="checkbox" name="property[]" value="10" <?php if(($property & pow(2,10)) != 0) echo('checked') ?>/>단체석(카페)<br>

            property_show:<br>
            <input type="checkbox" name="property_show[]" value="0" <?php if(($property_show & pow(2,0)) != 0) echo('checked') ?>/>배달
            <input type="checkbox" name="property_show[]" value="1" <?php if(($property_show & pow(2,1)) != 0) echo('checked') ?>/>포장
            <input type="checkbox" name="property_show[]" value="3" <?php if(($property_show & pow(2,3)) != 0) echo('checked') ?>/>예약(밥)<br>
            <input type="checkbox" name="property_show[]" value="9" <?php if(($property_show & pow(2,9)) != 0) echo('checked') ?>/>예약(술)
            <input type="checkbox" name="property_show[]" value="4" <?php if(($property_show & pow(2,4)) != 0) echo('checked') ?>/>대관
            <input type="checkbox" name="property_show[]" value="5" <?php if(($property_show & pow(2,5)) != 0) echo('checked') ?>/>단체석(술)<br>
            <input type="checkbox" name="property_show[]" value="6" <?php if(($property_show & pow(2,6)) != 0) echo('checked') ?>/>좌식
            <input type="checkbox" name="property_show[]" value="7" <?php if(($property_show & pow(2,7)) != 0) echo('checked') ?>/>흡연실
            <input type="checkbox" name="property_show[]" value="8" <?php if(($property_show & pow(2,8)) != 0) echo('checked') ?>/>1인석
            <input type="checkbox" name="property_show[]" value="10" <?php if(($property_show & pow(2,10)) != 0) echo('checked') ?>/>단체석(카페)<br>

            note: <input type="text" name="note" size="100" value="<?php echo($row['note']) ?>"/><br>
            lat: <input type="text" name="lat" size="100" value="<?php echo($row['lat']) ?>"/><br>
            lng: <input type="text" name="lng" size="100" value="<?php echo($row['lng']) ?>"/><br>
            addr_old: <input type="text" name="addr_old" size="100" value="<?php echo($row['addr_old']) ?>"/><br>
            addr_new: <input type="text" name="addr_new" size="100" value="<?php echo($row['addr_new']) ?>"/><br>

            key: <input type="text" name="key"/><br>
            <input type="submit" value="submit" /><br>
        </form>
    </body>
</html>
