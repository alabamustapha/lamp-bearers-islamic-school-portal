<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $__env->yieldContent('title'); ?> | Result</title>
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/schoolite.css')); ?>" rel="stylesheet">


</head>

<body class="white-bg result-page">
       <input type="hidden" value="<?php echo e(isset($first_term_avg) ? $first_term_avg : null); ?>" name="first_term_avg">
       <input type="hidden" value="<?php echo e(isset($second_term_avg) ? $second_term_avg : null); ?>" name="second_term_avg">
       <input type="hidden" value="<?php echo e(isset($third_term_avg) ? $third_term_avg : null); ?>" name="third_term_avg">

      <div class="wrapper wrapper-content">

           <?php echo $__env->yieldContent('result-heading'); ?>

           <?php echo $__env->yieldContent('result-body'); ?>

           <?php echo $__env->yieldContent('result-footer'); ?>
      </div>

    <!-- Custom and plugin javascript -->

    


    <!-- chart js -->
    <script src="<?php echo e(asset("js/plugins/chartJs/Chart.min.js")); ?>"></script>


    <script>

        var first_term_avg = document.querySelector("input[name='first_term_avg']").value;
        var second_term_avg = document.querySelector("input[name='second_term_avg']").value;
        var third_term_avg = document.querySelector("input[name='third_term_avg']").value;
         var barData = {
                labels: ["First", "Second", "Third"],
                datasets: [
                    {
                        label: "Termly Performance",
                        backgroundColor: 'rgba(26,179,148,0.5)',
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [first_term_avg, second_term_avg, third_term_avg]
                    }
                ]
            };

            var barOptions = {
                responsive: true,
                scales: {
                        yAxes: [{
                            ticks: {
                                max: 100,
                                min: 0,
                                stepSize: 20,
                                beginAtZero: true
                            }
                        }]
                    }
            };


            var ctx2 = document.getElementById("barChart").getContext("2d");
            new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

    </script>

    <script type="text/javascript">
            window.print();
        </script>
</body>

</html>
