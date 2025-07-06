<style>
    body {
        font-family: "TH SarabunPSK", "Arial", sans-serif;
        margin: 30px;
        color: #000;
        background-color: #fff;
        font-size: 20px;
    }

    h3 {
        text-align: center;
        font-size: 32px;
        margin-bottom: 0;
        font-weight: bold;
    }

    h4 {
        text-align: center;
        font-size: 24px;
        margin-top: 5px;
        margin-bottom: 30px;
    }

    .invoice-info {
        margin-bottom: 25px;
        line-height: 1.9;
        font-size: 20px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 18px;
        min-width: 400px;
    }

    table,
    th,
    td {
        border: 1px solid #000;
    }

    thead tr {
        background-color: #e9e9e9;
    }

    td,
    th {
        padding: 12px;
    }

    tfoot td {
        font-weight: bold;
        background-color: #f5f5f5;
    }

    .receipt-footer {
        margin-top: 40px;
        font-size: 18px;
        line-height: 1.8;
    }

    .receipt-footer .signature {
        margin-top: 60px;
        text-align: right;
    }

    .signature-line {
        display: inline-block;
        width: 200px;
        border-top: 1px solid #000;
        text-align: center;
    }

    @media (max-width: 600px) {
        body {
            margin: 15px;
            font-size: 16px;
        }

        h3 {
            font-size: 26px;
        }

        h4 {
            font-size: 22px;
        }

        table {
            font-size: 16px;
        }
    }
</style>

<h3>ใบเสร็จรับเงิน</h3>
<h4>{{ $organization->name }}</h4>

<div class="invoice-info">
    <div>วันที่ออกใบเสร็จ : {{ date('d/m/Y', strtotime($billing->created_at)) }}</div>
    <div>ได้รับเงินจาก : {{ $billing->getCustomer()->name }}</div>
    <div>เบอร์โทรศัพท์ : {{ $billing->getCustomer()->phone }}</div>
    <div>ห้องพักเลขที่ : {{ $billing->room->name }}</div>
    <div>งวดชำระของเดือน : {{ date('m/Y', strtotime($billing->created_at)) }}</div>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>รายการ</th>
                <th align="right" width="120px">จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ค่าเช่าห้องพัก</td>
                <td align="right">{{ number_format($billing->amount_rent) }}</td>
            </tr>
            <tr>
                <td>ค่าน้ำ</td>
                <td align="right">{{ number_format($billing->amount_water) }}</td>
            </tr>
            <tr>
                <td>ค่าไฟฟ้า</td>
                <td align="right">{{ number_format($billing->amount_electric) }}</td>
            </tr>
            <tr>
                <td>ค่าฟิตเนส</td>
                <td align="right">{{ number_format($billing->amount_fitness) }}</td>
            </tr>
            <tr>
                <td>ค่าชักรีด</td>
                <td align="right">{{ number_format($billing->amount_wash) }}</td>
            </tr>
            <tr>
                <td>ค่าเก็บขยะ</td>
                <td align="right">{{ number_format($billing->bin) }}</td>
            </tr>
            <tr>
                <td>ค่าใช้จ่ายอื่น ๆ</td>
                <td align="right">{{ number_format($billing->etc) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="right">รวมเป็นเงินทั้งสิ้น</td>
                <td align="right">{{ number_format($billing->sumAmount()) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    window.print();
</script>
