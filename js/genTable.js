function GenTable(idx, nums) {
    this.nums = nums;
    this.idx = idx;
}
GenTable.prototype = {
    genTable: function() {
        let rows = '<table id="content' + this.idx + '" class="content" cellpadding="0" cellspacing="0"><tr><td colspan="3"><span class="date">日期：　　　年　　　月　　　日</span></td><td colspan="2"><span class="time">完成用时：</span></td></tr>';
        let row = '';
        for (var i = 0; i < this.nums.length; i++) {
            row = '';
            for (var j = 0; j < this.nums[i].length; j += 2) {

                if (j == 0 || (j + 1) % 10 == 1) {
                    row += '<tr>';
                }
                switch (i) {
                    case 0:
                        row += '<td>' + this.nums[i][j] + '+' + this.nums[i][j + 1] + '=</td>';
                        break;
                    case 1:
                        row += '<td>' + this.nums[i][j] + '-' + this.nums[i][j + 1] + '=</td>';
                        break;
                    case 2:
                        row += '<td>' + this.nums[i][j] + '×' + this.nums[i][j + 1] + '=</td>';
                        break;
                    case 3:
                        row += '<td>' + this.nums[i][j] + '÷' + this.nums[i][j + 1] + '=</td>';
                        break;
                }

                if ((j + 2) % 10 == 0) {
                    row += '</tr>';
                }
            }
            rows += row;
        }
        rows += '</table>'
        return rows;
    }
}