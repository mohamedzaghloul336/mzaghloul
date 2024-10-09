<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حاسبة الأقساط</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: right;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>حاسبة الأقساط</h2>
    <form method="post" action="">
        <label for="price">سعر المنتج:</label>
        <input type="number" id="price" name="price" required>

        <label for="down_payment">مقدم الدفع:</label>
        <input type="number" id="down_payment" name="down_payment" required>

        <label for="net_price">السعر الصافي للمنتج:</label>
        <input type="number" id="net_price" name="net_price" required>

        <label for="installments">عدد الأشهر:</label>
        <input type="number" id="installments" name="installments" required>

        <label for="profit">نسبة الربح (%):</label>
        <input type="number" id="profit" name="profit" value="30" required>

        <label for="desired_installment">القسط المناسب:</label>
        <input type="number" id="desired_installment" name="desired_installment" required>

        <button type="submit">احسب</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $سعر_المنتج = $_POST['price'];
        $مقدم_الدفع = $_POST['down_payment'];
        $السعر_الصافي = $_POST['net_price'];
        $عدد_الاشهر = $_POST['installments'];
        $نسبة_الربح = $_POST['profit'];
        $قسط_مناسب = $_POST['desired_installment'];

        // دالة لحساب القسط الشهري بناءً على المبلغ المتبقي بعد المقدم
        function حساب_القسط_الشهري($سعر_المنتج, $مقدم_الدفع, $عدد_الاشهر, $نسبة_الربح = 30) {
            $المتبقي_بعد_المقدم = $سعر_المنتج - $مقدم_الدفع;
            $الربح = $المتبقي_بعد_المقدم * ($نسبة_الربح / 100);
            $المبلغ_الاجمالي_بعد_الربح = $المتبقي_بعد_المقدم + $الربح;
            $القسط_الشهري = $المبلغ_الاجمالي_بعد_الربح / $عدد_الاشهر;
            return $القسط_الشهري;
        }

        // دالة لحساب عدد الأقساط المقبولة بناءً على المبلغ المتبقي
        function حساب_عدد_الاقساط($سعر_المنتج, $مقدم_الدفع, $قسط_مناسب, $نسبة_الربح = 30) {
            $المتبقي_بعد_المقدم = $سعر_المنتج - $مقدم_الدفع;
            $الربح = $المتبقي_بعد_المقدم * ($نسبة_الربح / 100);
            $المبلغ_الاجمالي_بعد_الربح = $المتبقي_بعد_المقدم + $الربح;
            $عدد_الاقساط_المقبولة = ceil($المبلغ_الاجمالي_بعد_الربح / $قسط_مناسب);
            return $عدد_الاقساط_المقبولة;
        }

        // دالة لحساب أفضل قسط للسعر الصافي في 3 أشهر
        function حساب_افضل_قسط($السعر_الصافي, $مقدم_الدفع, $عدد_الاشهر = 3) {
            $المتبقي_من_السعر_الصافي = $السعر_الصافي - $مقدم_الدفع;
            return $المتبقي_من_السعر_الصافي / $عدد_الاشهر;
        }

        // حساب القسط الشهري وعدد الأقساط المقبولة بناءً على المبلغ المتبقي بعد المقدم
        $القسط_الشهري = حساب_القسط_الشهري($سعر_المنتج, $مقدم_الدفع, $عدد_الاشهر, $نسبة_الربح);
        $عدد_الاقساط_المقبولة = حساب_عدد_الاقساط($سعر_المنتج, $مقدم_الدفع, $قسط_مناسب, $نسبة_الربح);

        // حساب أفضل قسط لتحصيل السعر الصافي في 3 أشهر بعد طرح قيمة المقدم
        $افضل_قسط_للصافي = حساب_افضل_قسط($السعر_الصافي, $مقدم_الدفع);

        echo "<div class='result'>";
        echo "<strong>القسط الشهري:</strong> " . number_format($القسط_الشهري, 2) . " جنيه<br>";
        echo "<strong>عدد الأقساط المقبولة:</strong> " . $عدد_الاقساط_المقبولة . " قسط<br>";
        echo "<strong>أفضل قسط لتحصيل السعر الصافي في 3 أشهر:</strong> " . number_format($افضل_قسط_للصافي, 2) . " جنيه";
        echo "</div>";
    }
    ?>
</div>

</body>
</html>
