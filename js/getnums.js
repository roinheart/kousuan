/**
 * @function 二则运算算式生成类构造函数
 * @param formulaCount Array 算式数量数组：idx{0-加法，1-减法，2-乘法，3-除法} 
 * @param bits 2DJsonArray 操作数最大最小位数：
 * Array{
 * 		Array{
 * 		 		0-被加数最小值，1-被加数最大值，2-加数最小值，3-加数最大值
 * 		}
 * 		Array{
 * 				0-被减数最小值，1-被减数最大值，2-减数最小值位数，3-减数最大值
 * 		}
 * 		Array{
 * 				0-被乘数最小值，1-被乘数最大值，2-乘数最小值位数，3-乘数最大值
 * 		}
 * 		Array{
 * 				0-被除数最小值，1-被除数最大值，2-除数最小值位数，3-除数最大值
 * 		}
 * }
 */
function GetNums(formulaCount, numsRange, ismod) {
    this.formulaCount = formulaCount;
    this.numsRange = numsRange;
    this.ismod = ismod;
}
/** @type Generator 算式生成类 **/
GetNums.prototype = {
    optNums: function() {
        let result = new Array();
        result.push(this.getAddNums(this.formulaCount[0], this.numsRange.add));
        result.push(this.getMinusNums(this.formulaCount[1], this.numsRange.minus));
        result.push(this.getMulNums(this.formulaCount[2], this.numsRange.mul));
        result.push(this.getDiviNums(this.formulaCount[3], this.numsRange.divi, this.ismod));
        return result;
    },
    /**
     *
     * @param  count int 算式数量
     * @param  numRange Array 操作数最大值最小值
     * @param  ismod boolean 是否有余数
     * @param  greaterThen10 boolean 商是否大于10
     * @return nums Array 减法法操作数数组
     */
    getDiviNums: function(count, numRange, ismod = true) {
        let nums = new Array(count * 2);
        let f_min = numRange[0];
        let f_max = numRange[1];
        let s_min = numRange[2];
        let s_max = numRange[3];
        let exit = 0;
        let mul = 0;
        let r;
        for (var i = 0; i < nums.length; i += 2) {
            while (exit == 0) {
                nums[i] = this.randomNum(f_min, f_max);
                nums[i + 1] = this.randomNum(s_min, s_max);

                if (nums[i + 1] * nums[i] >= 10) {
                    exit = 1;
                }


            }
            mul = nums[i] * nums[i + 1];
            nums[i] = mul;
            if (ismod) {
                nums[i] += this.randomNum(1, 9);
            }
            exit = 0
        }
        return nums;
    },
    /**
     *
     * @param  count int 算式数量
     * @param  numRange Array 操作数最大值最小值
     *
     * @return nums Array 减法法操作数数组
     */
    getMinusNums: function(count, numRange) {
        let nums = new Array(count * 2);
        let f_min = numRange[0];
        let f_max = numRange[1];
        let s_min = numRange[2];
        let s_max = numRange[3];
        let exit = 0;
        for (var i = 0; i < nums.length; i += 2) {
            while (exit == 0) {
                nums[i] = this.randomNum(f_min, f_max);
                nums[i + 1] = this.randomNum(s_min, s_max);
                exit = nums[i] > nums[i + 1] ? 1 : 0;
            }
            exit = 0
        }
        return nums;
    },
    /**
     *
     * @param  count int 算式数量
     * @param  numRange Array 操作数最大值最小值
     *
     * @return nums Array 乘法操作数数组
     */
    getMulNums: function(count, numRange) {
        let nums = new Array(count * 2);
        let f_min = numRange[0];
        let f_max = numRange[1];
        let s_min = numRange[2];
        let s_max = numRange[3];
        let exit = 0;
        for (var i = 0; i < nums.length; i += 2) {
            while (exit == 0) {
                nums[i] = this.randomNum(f_min, f_max, 'mul');
                nums[i + 1] = this.randomNum(s_min, s_max, 'mul');
                if (nums[i + 1] * nums[i] >= 4) {
                    exit = 1;
                }
            }
            exit = 0;
        }
        return nums;
    },
    /**
     *
     * @param  count int 算式数量
     * @param  numRange Array 操作数最大值最小值
     *
     * @return nums Array 加法操作数数组
     */
    getAddNums: function(count, numRange) {
        let nums = new Array(count * 2);
        let f_min = numRange[0];
        let f_max = numRange[1];
        let s_min = numRange[2];
        let s_max = numRange[3];
        for (var i = 0; i < nums.length; i += 2) {
            nums[i] = this.randomNum(f_min, f_max);
            nums[i + 1] = this.randomNum(s_min, s_max);
        }
        return nums;
    },
    //生成从minNum到maxNum的随机数
    randomNum: function(min, max, type = null) {

        return Math.floor(Math.random() * (max - min + 1)) + min;
        //或者 Math.floor(Math.random()*( maxNum - minNum + 1 ) + minNum );
    },
}