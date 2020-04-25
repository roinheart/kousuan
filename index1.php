<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>小娃口算</title>
    <link rel="stylesheet" href="/css/base.css">
</head>

<body>
    <header>
        <div class="select-bar">
            <p>
                <span>运算符号：</span>
                <select id="symbol">
                    <option selected value="0">随机</option>
                    <option value="1">加减</option>
                    <option value="2">乘除</option>
                </select>
            </p>
            <p>
                <span>空头空中间：</span>
                <input type="number" id="HorM" value="0">
                <span>生成几个等式：</span>
                <input type="number" id="equal" value="0">
            </p>
            <p>
                <span class="btn" id="generator">生成</span><span class="btn" id="check_answer" onclick="check_answer(this)">查看答案</span><span class="btn" id="print" onclick="print()">打印</span><input type="number" id="offset" maxlength="1" value="1">
            </p>
        </div>
    </header>
    <section>
        <div class="content" id="content">
        </div>
    </section>
</body>
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery.print.js"></script>
<script type="text/javascript">
let formula = new Array();
let result = new Array();
let symbol = parseInt($("#symbol").val());
let answer = parseInt($("#answer").val());
let HorM = parseInt($("#HorM").val());
let equal = parseInt($("#equal").val());
$(function() {
    $("#generator").click(function() {

        set_parse();
        let offset = $("#offset").val();
        for (var i = 1; i <= offset; i++) {
            formula = new Array();
            result = new Array();
            generator_formula();
            gernerator_table(i);
        }

    });
});

function check_answer(ele) {
    if (!formula.length) {
        alert('没有生成算式！')
        return false;
    }
    if ($(ele).text() == '查看答案') {
        $('.answer').removeClass('hide');
        $(ele).text('隐藏答案')
    } else {
        $('.answer').addClass('hide');
        $(ele).text('查看答案')
    }

}

function print() {
    $('.content').print()
    // $.ajax({
    //     url: '/kousuan/save',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {html: $('.content').html()},
    // })
    // .done(function(data) {
    //     alert(data.msg)
    // })
}

function gernerator_table(idx) {
    let html = '<table cellspacing="0" id="tb'+idx+'"><tr><td colspan="3"><span class="date">日期：　　　年　　　月　　　日</span></td><td colspan="2"><span class="time">完成用时：</span></td></tr><tr>';
    formula=formula.sort(function(){ return 0.5 - Math.random()});
    $.each(formula, function(index, val) {
        let n = index + 1;
        // html += '<td style="width:20%;">' + val + '<span class="answer hide">' + result[index] + '</span></td>';
        html += '<td style="width:20%;">' + val + '</td>';
        if (n % 5 == 0) {
            if (n != 50) {
                html += '</tr><tr>';
            } else {
                html += '</tr></table>';
            }

        }
    });
    $("#content").html($("#content").html()+html);
}

function set_parse() {
    symbol = parseInt($("#symbol").val());
    answer = parseInt($("#answer").val());
    HorM = parseInt($("#HorM").val());
    equal = parseInt($("#equal").val());
}

function generator_formula() {

    let first_num, second_num;
    let formula_num = 50 - HorM - equal;

    let symbol_num = 1;
    for (var i = 0; i < formula_num; i++) {

        switch (symbol) {
            case 0:
                // symbol_num = randomNum(0, 3);
                // symbol_num =1;
                if (i<15) {
                    symbol_num=0;
                }else if (i<35) {
                    symbol_num=1;
                }else if (i<40){
                    symbol_num=2;
                }else if (i<50){
                    symbol_num=3;
                }
                switch (symbol_num) {
                    case 0:
                        set_result(add());
                        break;
                    case 1:
                        set_result(minus());
                        break;
                    case 2:
                        set_result(multiplication());
                        break;
                    case 3:
                        set_result(division());
                        break;
                }
                break;
            case 1:
                symbol_num = randomNum(0, 1);
                switch (symbol_num) {
                    case 0:
                        set_result(add());
                        break;
                    case 1:
                        set_result(minus());
                        break;
                }
                break;
            case 2:
                symbol_num = randomNum(0, 1);
                switch (symbol_num) {
                    case 0:
                        set_result(multiplication());
                        break;
                    case 1:
                        set_result(division());
                        break;
                }
                break;
        }
    }
    for (var i = 0; i < HorM; i++) {
        switch (randomNum(0, 3)) {
            case 0:
                set_result(add(0));
                break;
            case 1:
                set_result(minus(0));
                break;
            case 2:
                set_result(multiplication(0));
                break;
            case 3:
                set_result(division(0));
                break;
        }
    }

    for (var i = 0; i < equal; i++) {
        set_equal(randomNum(0, 2))
    }
}

function set_equal(num) {
    let first_result, second_result, one, two, three, four, set_r = new Array(2);
    switch (num) {
        case 0:
            switch (randomNum(0, 1)) {
                case 0:
                    first_result = add(0);
                    second_result = minus(1);
                    break;
                case 1:
                    first_result = add(1);
                    second_result = minus(0);
                    break;
            }
            while (first_result[1] != second_result[1]) {
                switch (randomNum(0, 1)) {
                    case 0:
                        first_result = add(0);
                        second_result = minus(1);
                        break;
                    case 1:
                        first_result = add(1);
                        second_result = minus(0);
                        break;
                }
            }
            set_r[0] = first_result[0].substr(0, first_result[0].indexOf('=')) + "=" + second_result[0].substr(0, second_result[0].indexOf('='));
            set_r[1] = first_result[1];
            set_result(set_r);
            break;
        case 1:
            switch (randomNum(0, 1)) {
                case 0:
                    first_result = add(0);
                    second_result = multiplication(1);
                    break;
                case 1:
                    first_result = add(1);
                    second_result = multiplication(0);
                    break;
            }
            while (first_result[1] != second_result[1]) {
                switch (randomNum(0, 1)) {
                    case 0:
                        first_result = add(0);
                        second_result = multiplication(1);
                        break;
                    case 1:
                        first_result = add(1);
                        second_result = multiplication(0);
                        break;
                }
            }
            set_r[0] = first_result[0].substr(0, first_result[0].indexOf('=')) + "=" + second_result[0].substr(0, second_result[0].indexOf('='));
            set_r[1] = first_result[1];
            set_result(set_r);
            break;
        case 2:
            switch (randomNum(0, 1)) {
                case 0:
                    first_result = add(0);
                    second_result = add();
                    break;
                case 1:
                    first_result = add();
                    second_result = add(0);
                    break;
            }
            while (first_result[1] != second_result[1]) {
                switch (randomNum(0, 1)) {
                    case 0:
                        first_result = add(0);
                        second_result = add();
                        break;
                    case 1:
                        first_result = add();
                        second_result = add(0);
                        break;
                }
            }
            set_r[0] = first_result[0].substr(0, first_result[0].indexOf('=')) + "=" + second_result[0].substr(0, second_result[0].indexOf('='));
            set_r[1] = first_result[1];
            set_result(set_r);
            break;
    }
}

function set_result(arr) {
    formula.push(arr[0]);
    result.push(arr[1]);
}

function duplicate_removal(str) {
    let r = 0;
    $.each(formula, function(index, val) {
        /* iterate through array or object */
        if (val == str) {
            r = 1;
        }
    });
    return r;
}

function division(nothing = 1) {
    let num1 = randomNum(1, 9);
    let num2 = randomNum(1, 9);
    while (num1 == 1 || num2 == 1) {
        num1 = randomNum(1, 9);
        num2 = randomNum(1, 9);
    }
    let divisor = num1 * num2;
    let str = '';

    if (nothing) {
        str = divisor + '÷' + num2 + '=';
    } else {
        if (randomNum(0, 1)) {
            str = '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '÷' + num2 + '=' + num1;
        } else {
            str = divisor + '÷' + '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '=' + num1;
        }
    }

    if (duplicate_removal(str)) { division() };
    let r = [0, 1, 2, 3, 4];
    r[0] = str;
    r[1] = num1;
    r[2] = divisor;
    r[3] = num1;
    r[4] = num2;
    return r;
}

function multiplication(nothing = 1) {
    let num1 = randomNum(1, 9);
    let num2 = randomNum(1, 9);
    while (num1 == 1 || num2 == 1) {
        num1 = randomNum(1, 9);
        num2 = randomNum(1, 9);
    }
    let num = num1 * num2;
    let str = '';
    if (nothing) {
        str = num1 + '×' + num2 + '=';
    } else {
        if (randomNum(0, 1)) {
            str = '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '×' + num2 + '=' + num;
        } else {
            str = num1 + '×' + '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '=' + num;
        }
    }
    if (duplicate_removal(str)) { multiplication() };
    let r = [0, 1, 2, 3, 4];
    r[0] = str;
    r[1] = num;
    r[2] = num;
    r[3] = num1;
    r[4] = num2;
    return r;
}

function minus(nothing = 1) {
    let num1 = randomNum(10, 99);
    let num2 = randomNum(10, 99);
    let s=0;
    if (num1 < num2) {
        s=num1;
        num1=num2;
        num2=s;
    }
    let n1=parseInt(num1.toString().charAt(1));
    let n2=parseInt(num2.toString().charAt(1));
    while (n1>=n2 || n1==0){

        num1 = randomNum(10, 99);
        num2 = randomNum(10, 99);
        if (num1 < num2) {
            s=num1;
            num1=num2;
            num2=s;
        }
        n1=parseInt(num1.toString().charAt(1));
        n2=parseInt(num2.toString().charAt(1));

    }

    let num = num1 - num2;
    let str = '';
    if (nothing) {
        str = num1 + '-' + num2 + '=';
    } else {
        if (randomNum(0, 1)) {
            str = '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '-' + num2 + '=' + num;
        } else {
            str = num1 + '-' + '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '=' + num;
        }
    }
    if (duplicate_removal(str)) { minus() };
    let r = [0, 1, 2, 3, 4];
    r[0] = str;
    r[1] = num;
    r[2] = num;
    r[3] = num1;
    r[4] = num2;
    return r;
}

function add(nothing = 1) {
    let num1 = randomNum(10, 99);
    let num2 = randomNum(10, 99);
    let num = num1 + num2;
    while (num > 100) {
        num1 = randomNum(10, 99);
        num2 = randomNum(10, 99);
        num = num1 + num2;
    }
    let str = '';
    if (nothing) {
        str = num1 + '+' + num2 + '=';
    } else {
        if (randomNum(0, 1)) {
            str = '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '+' + num2 + '=' + num;
        } else {
            str = num1 + '+' + '(&nbsp;&nbsp;&nbsp;&nbsp;)' + '=' + num;
        }
    }
    if (duplicate_removal(str)) { add() };
    let r = [0, 1, 2, 3, 4];
    r[0] = str;
    r[1] = num;
    r[2] = num;
    r[3] = num1;
    r[4] = num2;
    return r;
}
//生成从minNum到maxNum的随机数
function randomNum(minNum, maxNum) {
    switch (arguments.length) {
        case 1:
            return parseInt(Math.random() * minNum + 1, 10);
            break;
        case 2:
            return parseInt(Math.random() * (maxNum - minNum + 1) + minNum, 10);
            //或者 Math.floor(Math.random()*( maxNum - minNum + 1 ) + minNum );
            break;
        default:
            return 0;
            break;
    }
}
</script>

</html>