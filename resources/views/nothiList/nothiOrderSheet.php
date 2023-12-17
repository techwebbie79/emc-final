
<html>
    <!-- <title><?=$page_title?></title> -->
    <style>
        @font-face {
            font-family: 'Kalpurush';
            src: url('../fonts/Kalpurush.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nikosh';
            src: url('../fonts/Nikosh.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body,
        html {
            font-family: 'Kalpurush', Poppins, Helvetica, sans-serif;
            font-size: 14px!important;
        }

    </style>
<body onload="onload()">
    <?php foreach($appealOrderLists as $key=>$row){?>
        <div class="contentForm" style="font-size: medium;">
            <?php if($key == 0){?>
                <div id="head">
                    <?php echo nl2br($row->order_header) ?>
                </div>
            <?php } ?>
    <?php }?>
            <div id="body" style="overflow: hidden;">
            <table cellspacing="0" cellpadding="0" border="1" width="100%">
               <thead>
                    <tr>
                        <td valign="middle" width="5%" align="center"> আদেশের ক্রমিক নং </td>
                        <td valign="middle" width="10%" align="center"> তারিখ</td>
                        <td valign="middle" width="75%" align="center"> আদেশ </td>
                        <td valign="middle" width="10%" align="center"> স্বাক্ষর</td>
                    </tr>
                </thead>
    <?php foreach($appealOrderLists as $key=>$row){?>
                <tbody>
                    <?php echo $row->order_detail_table_body ?>
                </tbody>
    <?php }?>
            </table>


            </div>
            <h3 id="rayNamaHeading" style="text-align: center;"></h3>
            <div id="rayHeadAppealNama" class="ray-head"></div>
            <div id="rayBodyAppealNama" class="ray-body"></div>
        </div>

        <script type="text/javascript">
            function onload() {
               // var url = window.location.search.substring(1)
               // var img = document.getElementById('img')
               // img.src = url
               window.print()
            }
        </script>
</body>

</html>
