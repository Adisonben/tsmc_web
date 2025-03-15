<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สร้างงานใหม่ - Transport Safety Manager</title>
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #0d47a1;
            --success: #34a853;
            --warning: #fbbc05;
            --danger: #ea4335;
            --light-gray: #f5f5f5;
            --gray: #757575;
            --dark: #212121;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            font-family: 'Sarabun', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f8f9fa;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .page-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 25px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 115, 232, 0.2);
        }

        .search-wrapper {
            position: relative;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper:after {
            content: '';
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid var(--gray);
            pointer-events: none;
        }

        select.form-control {
            appearance: none;
            padding-right: 30px;
            background-color: white;
        }

        .driver-list {
            border: 1px solid #ddd;
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
        }

        .driver-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .driver-item:last-child {
            border-bottom: none;
        }

        .driver-item:hover {
            background-color: var(--light-gray);
        }

        .driver-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #e0e0e0;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            font-weight: bold;
            font-size: 0.9rem;
        }

        .driver-info {
            flex: 1;
        }

        .driver-name {
            font-weight: 600;
        }

        .driver-status {
            font-size: 0.85rem;
            padding: 2px 8px;
            border-radius: 12px;
            display: inline-block;
        }

        .status-available {
            background-color: rgba(52, 168, 83, 0.1);
            color: var(--success);
        }

        .status-busy {
            background-color: rgba(251, 188, 5, 0.1);
            color: var(--warning);
        }

        .checklist-builder {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            background-color: var(--light-gray);
            border-radius: 4px;
        }

        .checklist-item input[type="checkbox"] {
            margin-right: 10px;
        }

        .add-item-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--primary);
            background: none;
            border: none;
            padding: 5px 0;
            font-size: 0.9rem;
            cursor: pointer;
            margin-top: 10px;
        }

        .priority-options {
            display: flex;
            gap: 15px;
        }

        .priority-option {
            flex: 1;
            border: 2px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .priority-normal {
            border-color: var(--success);
            color: var(--success);
        }

        .priority-normal.active {
            background-color: var(--success);
            color: white;
        }

        .priority-urgent {
            border-color: var(--warning);
            color: var(--warning);
        }

        .priority-urgent.active {
            background-color: var(--warning);
            color: white;
        }

        .priority-emergency {
            border-color: var(--danger);
            color: var(--danger);
        }

        .priority-emergency.active {
            background-color: var(--danger);
            color: white;
        }

        .date-time-group {
            display: flex;
            gap: 15px;
        }

        .date-time-group .form-group {
            flex: 1;
        }

        .btn {
            display: inline-block;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 6px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-primary {
            color: white;
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        .text-right {
            text-align: right;
        }

        .full-width {
            grid-column: 1 / -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <div class="logo-icon">TSM</div>
                Transport Safety Manager
            </div>
            <div class="user-info">
                <span>ยินดีต้อนรับ, ผู้ดูแลระบบ</span>
                <div class="user-avatar">A</div>
            </div>
        </div>

        <h1 class="page-title">สร้างงานใหม่</h1>

        <form>
            <div class="card">
                <div class="form-grid">
                    <!-- เลือกรถ -->
                    <div class="form-group">
                        <label class="form-label">เลือกรถ</label>
                        <div class="select-wrapper">
                            <select class="form-control">
                                <option value="" disabled selected>เลือกรถที่พร้อมใช้งาน</option>
                                <option value="1">รถตู้ Toyota - ทะเบียน กข-1234 (พร้อมใช้งาน)</option>
                                <option value="2">รถบัส Hino - ทะเบียน งจ-5678 (พร้อมใช้งาน)</option>
                                <option value="3">รถเก๋ง Honda - ทะเบียน ฉช-9012 (พร้อมใช้งาน)</option>
                            </select>
                        </div>
                    </div>

                    <!-- มอบหมายพนักงานขับรถ -->
                    <div class="form-group">
                        <label class="form-label">มอบหมายพนักงานขับรถ</label>
                        <div class="search-wrapper">
                            <input type="text" class="form-control" placeholder="ค้นหาพนักงานขับรถ">
                            <span class="search-icon">🔍</span>
                        </div>
                        <div class="driver-list">
                            <div class="driver-item">
                                <div class="driver-avatar">สม</div>
                                <div class="driver-info">
                                    <div class="driver-name">สมชาย ใจดี</div>
                                    <div class="driver-status status-available">พร้อมทำงาน</div>
                                </div>
                            </div>
                            <div class="driver-item">
                                <div class="driver-avatar">วิ</div>
                                <div class="driver-info">
                                    <div class="driver-name">วิชัย รักงาน</div>
                                    <div class="driver-status status-available">พร้อมทำงาน</div>
                                </div>
                            </div>
                            <div class="driver-item">
                                <div class="driver-avatar">มา</div>
                                <div class="driver-info">
                                    <div class="driver-name">มานะ ตั้งใจ</div>
                                    <div class="driver-status status-busy">กำลังปฏิบัติงาน</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- เครื่องมือสร้างเช็คลิสต์ -->
                    <div class="form-group full-width">
                        <label class="form-label">เช็คลิสต์งาน</label>
                        <div class="checklist-builder">
                            <div class="checklist-item">
                                <input type="checkbox" checked>
                                <span>ตรวจสอบน้ำมันและของเหลวในรถ</span>
                            </div>
                            <div class="checklist-item">
                                <input type="checkbox" checked>
                                <span>ตรวจสอบลมยางและความพร้อมของล้อ</span>
                            </div>
                            <div class="checklist-item">
                                <input type="checkbox" checked>
                                <span>ตรวจสอบไฟและระบบส่องสว่าง</span>
                            </div>
                            <div class="checklist-item">
                                <input type="checkbox" checked>
                                <span>ทำ Roll Call ก่อนออกเดินทาง</span>
                            </div>
                            <div class="checklist-item">
                                <input type="checkbox" checked>
                                <span>รายงานสถานะทุก 1 ชั่วโมงระหว่างเดินทาง</span>
                            </div>
                            <button type="button" class="add-item-btn">+ เพิ่มรายการใหม่</button>
                        </div>
                    </div>

                    <!-- การตั้งค่าความสำคัญ -->
                    <div class="form-group">
                        <label class="form-label">ระดับความสำคัญ</label>
                        <div class="priority-options">
                            <div class="priority-option priority-normal active">
                                ปกติ
                            </div>
                            <div class="priority-option priority-urgent">
                                ด่วน
                            </div>
                            <div class="priority-option priority-emergency">
                                ฉุกเฉิน
                            </div>
                        </div>
                    </div>

                    <!-- การกำหนดเวลา -->
                    <div class="form-group">
                        <label class="form-label">กำหนดเวลาส่งงาน</label>
                        <div class="date-time-group">
                            <div class="form-group">
                                <input type="date" class="form-control" value="2025-03-16">
                            </div>
                            <div class="form-group">
                                <input type="time" class="form-control" value="09:00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">ระยะเวลาดำเนินการโดยประมาณ</label>
                            <select class="form-control">
                                <option value="1">1 ชั่วโมง</option>
                                <option value="2" selected>2 ชั่วโมง</option>
                                <option value="3">3 ชั่วโมง</option>
                                <option value="4">4 ชั่วโมง</option>
                                <option value="8">8 ชั่วโมง</option>
                                <option value="12">12 ชั่วโมง</option>
                                <option value="24">1 วัน</option>
                            </select>
                        </div>
                    </div>

                    <!-- คำอธิบายงาน -->
                    <div class="form-group full-width">
                        <label class="form-label">คำอธิบายงาน</label>
                        <textarea class="form-control" rows="4" placeholder="กรอกรายละเอียดหรือคำแนะนำเพิ่มเติมเกี่ยวกับงานนี้"></textarea>
                    </div>
                </div>
            </div>

            <!-- ปุ่มส่ง -->
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-lg">สร้างงานใหม่</button>
            </div>
        </form>
    </div>
</body>
</html>
