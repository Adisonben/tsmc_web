<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Safety Manager - Driver Portal</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Kanit', 'Sarabun', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #0a3e69;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            text-align: center;
            padding: 10px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .driver-info {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
        }

        .driver-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #f5f5f5;
            margin-right: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0a3e69;
            font-weight: bold;
        }

        .driver-detail h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .driver-detail p {
            font-size: 12px;
            opacity: 0.8;
        }

        .menu-item {
            padding: 15px 20px;
            display: block;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sos-button {
            margin: 20px;
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sos-button i {
            margin-right: 10px;
        }

        .sos-button:hover {
            background-color: #c9302c;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .header-title h1 {
            font-size: 24px;
            color: #0a3e69;
        }

        .notifications {
            position: relative;
        }

        .notification-icon {
            font-size: 20px;
            cursor: pointer;
            color: #0a3e69;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #d9534f;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            color: #0a3e69;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
        }

        .task-list {
            list-style: none;
        }

        .task-item {
            padding: 15px;
            border-left: 4px solid #0a3e69;
            background-color: #f8f9fb;
            margin-bottom: 10px;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .task-item:hover {
            transform: translateX(5px);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .task-id {
            font-weight: bold;
        }

        .task-time {
            color: #666;
            font-size: 14px;
        }

        .task-details {
            display: flex;
            font-size: 14px;
            color: #666;
        }

        .task-details div {
            margin-right: 15px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: normal;
        }

        .badge-primary {
            background-color: #5bc0de;
            color: white;
        }

        .badge-success {
            background-color: #5cb85c;
            color: white;
        }

        .badge-warning {
            background-color: #f0ad4e;
            color: white;
        }

        .rollcall-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            margin-bottom: 30px;
        }

        .rollcall-title {
            font-size: 22px;
            margin-bottom: 15px;
            color: #0a3e69;
        }

        .rollcall-status {
            font-size: 16px;
            margin-bottom: 20px;
            color: #5cb85c;
        }

        .checkin-button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .checkin-button:hover {
            background-color: #4cae4c;
        }

        .checkin-button.disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }

        .inspection-form {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .form-header {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .form-section {
            margin-bottom: 25px;
        }

        .form-section-title {
            font-size: 18px;
            margin-bottom: 15px;
            color: #0a3e69;
        }

        .checklist-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .checklist-item:last-child {
            border-bottom: none;
        }

        .checklist-item-checkbox {
            margin-right: 15px;
            margin-top: 3px;
        }

        .checklist-item-content {
            flex: 1;
        }

        .checklist-item-label {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .checklist-item-desc {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .photo-upload {
            background-color: #f8f9fb;
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .photo-upload:hover {
            border-color: #0a3e69;
        }

        .photo-upload i {
            font-size: 24px;
            color: #999;
            margin-bottom: 10px;
        }

        .severity-selector {
            display: flex;
            margin-top: 10px;
        }

        .severity-option {
            flex: 1;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: all 0.3s;
        }

        .severity-option:first-child {
            border-radius: 5px 0 0 5px;
        }

        .severity-option:last-child {
            border-radius: 0 5px 5px 0;
        }

        .severity-option.low:hover,
        .severity-option.low.selected {
            background-color: #5cb85c;
            color: white;
            border-color: #5cb85c;
        }

        .severity-option.medium:hover,
        .severity-option.medium.selected {
            background-color: #f0ad4e;
            color: white;
            border-color: #f0ad4e;
        }

        .severity-option.high:hover,
        .severity-option.high.selected {
            background-color: #d9534f;
            color: white;
            border-color: #d9534f;
        }

        .submit-section {
            text-align: center;
            margin-top: 30px;
        }

        .signature-pad {
            width: 100%;
            height: 150px;
            background-color: #f8f9fb;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .signature-pad-content {
            border-bottom: 1px dashed #999;
            width: 80%;
            height: 60px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .signature-pad-label {
            font-size: 14px;
            color: #666;
        }

        .button-primary {
            background-color: #0a3e69;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-primary:hover {
            background-color: #072a48;
        }

        .button-secondary {
            background-color: #ddd;
            color: #333;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .button-secondary:hover {
            background-color: #ccc;
        }

        .task-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .task-detail-title {
            font-size: 22px;
            color: #0a3e69;
        }

        .task-detail-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            color: white;
            background-color: #f0ad4e;
        }

        .task-detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .task-detail-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .detail-section-title {
            font-size: 18px;
            margin-bottom: 15px;
            color: #0a3e69;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .detail-item {
            display: flex;
            margin-bottom: 12px;
        }

        .detail-label {
            width: 120px;
            color: #666;
        }

        .detail-value {
            font-weight: bold;
        }

        .map-container {
            height: 200px;
            background-color: #f0f0f0;
            border-radius: 5px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }

        .route-assessment {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .location-input {
            position: relative;
            margin-bottom: 20px;
        }

        .location-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #0a3e69;
        }

        .weather-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .weather-option {
            padding: 10px 15px;
            background-color: #f8f9fb;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .weather-option i {
            margin-right: 5px;
        }

        .weather-option:hover,
        .weather-option.selected {
            background-color: #0a3e69;
            color: white;
            border-color: #0a3e69;
        }

        .road-condition-options {
            margin-bottom: 20px;
        }

        .condition-option {
            display: block;
            margin-bottom: 10px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .form-textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
            height: 100px;
            resize: vertical;
        }

        .completion-checklist {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .completion-button {
            margin-top: 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            font-weight: bold;
        }

        .completion-button:hover {
            background-color: #4cae4c;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                overflow: hidden;
            }

            .main-content {
                margin-left: 0;
            }

            .dashboard-grid,
            .task-detail-grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-title {
                margin-bottom: 10px;
            }
        }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <!-- Left Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="/api/placeholder/100/100" alt="TSM Logo" />
                <h2>TSM Portal</h2>
            </div>

            <div class="driver-info">
                <div class="driver-avatar">ส</div>
                <div class="driver-detail">
                    <h3>สมชาย รักขับรถ</h3>
                    <p>รหัสพนักงาน: DRV-2023-001</p>
                </div>
            </div>

            <a href="#" class="menu-item active">
                <i class="fas fa-home"></i> หน้าหลัก
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-tasks"></i> งานที่ได้รับมอบหมาย
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-clipboard-check"></i> แบบฟอร์มตรวจสอบรถ
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-user-check"></i> ระบบเช็คอิน (Roll Call)
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-road"></i> ประเมินเส้นทาง
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-history"></i> ประวัติงาน
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-cog"></i> ตั้งค่า
            </a>

            <button class="sos-button">
                <i class="fas fa-exclamation-triangle"></i> ฉุกเฉิน (SOS)
            </button>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-title">
                    <h1>พอร์ทัลพนักงานขับรถ</h1>
                    <p>วันเสาร์ที่ 15 มีนาคม 2568 | 08:30 น.</p>
                </div>
                <div class="notifications">
                    <i class="fas fa-bell notification-icon"></i>
                    <span class="notification-badge">3</span>
                </div>
            </div>

            <!-- Roll Call Section -->
            <div class="rollcall-section">
                <h2 class="rollcall-title">ระบบเช็คอิน (Roll Call)</h2>
                <p class="rollcall-status">สถานะ: ยังไม่ได้เช็คอินวันนี้</p>
                <button class="checkin-button">
                    <i class="fas fa-map-marker-alt"></i> เช็คอินตอนนี้
                </button>
            </div>

            <!-- Dashboard -->
            <div class="dashboard-grid">
                <!-- Assigned Tasks -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2 class="card-title">งานที่ได้รับมอบหมาย</h2>
                        <span class="badge badge-primary">3 งาน</span>
                    </div>
                    <ul class="task-list">
                        <li class="task-item">
                            <div class="task-header">
                                <span class="task-id">TSK-2023-0568</span>
                                <span class="task-time">08:30 - 12:00 น.</span>
                            </div>
                            <p>ขนส่งสินค้าจากคลัง A ไปยังลูกค้าจังหวัดระยอง</p>
                            <div class="task-details">
                                <div>ระยะทาง: 180 กม.</div>
                                <div>สถานะ: <span class="badge badge-warning">รอดำเนินการ</span></div>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-header">
                                <span class="task-id">TSK-2023-0569</span>
                                <span class="task-time">13:30 - 16:00 น.</span>
                            </div>
                            <p>ขนส่งสินค้าจากระยองกลับมายังคลัง A</p>
                            <div class="task-details">
                                <div>ระยะทาง: 180 กม.</div>
                                <div>สถานะ: <span class="badge badge-warning">รอดำเนินการ</span></div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Pre-trip Inspection -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2 class="card-title">การตรวจสอบรถก่อนออกเดินทาง</h2>
                    </div>
                    <p style="margin-bottom: 15px;">กรุณาทำการตรวจสอบรถก่อนออกเดินทางตามขั้นตอน</p>
                    <a href="#" class="button-primary"
                        style="display: block; text-align: center; text-decoration: none;">ทำการตรวจสอบตอนนี้</a>
                </div>
            </div>

            <!-- Vehicle Inspection Form -->
            <div class="inspection-form">
                <div class="form-header">
                    <h2>แบบฟอร์มตรวจสอบรถ</h2>
                    <p>รหัสรถ: TRK-2023-042 | ป้ายทะเบียน: กข-1234 กรุงเทพมหานคร</p>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">ตรวจสอบภายนอกรถ</h3>

                    <div class="checklist-item">
                        <input type="checkbox" class="checklist-item-checkbox" id="exterior-1">
                        <div class="checklist-item-content">
                            <label for="exterior-1" class="checklist-item-label">สภาพยางรถทั้ง 6 ล้อ</label>
                            <p class="checklist-item-desc">ตรวจสอบความลึกของดอกยาง รอยฉีกขาด และความดันลมยาง</p>

                            <div class="photo-upload">
                                <i class="fas fa-camera"></i>
                                <p>คลิกเพื่อถ่ายภาพยางรถ</p>
                            </div>

                            <div class="severity-selector">
                                <div class="severity-option low">ปกติ</div>
                                <div class="severity-option medium">ต้องตรวจสอบ</div>
                                <div class="severity-option high">ต้องซ่อมด่วน</div>
                            </div>
                        </div>
                    </div>

                    <div class="checklist-item">
                        <input type="checkbox" class="checklist-item-checkbox" id="exterior-2">
                        <div class="checklist-item-content">
                            <label for="exterior-2" class="checklist-item-label">ไฟหน้า ไฟท้าย ไฟเลี้ยว</label>
                            <p class="checklist-item-desc">ตรวจสอบการทำงานของไฟทุกดวง</p>

                            <div class="photo-upload">
                                <i class="fas fa-camera"></i>
                                <p>คลิกเพื่อถ่ายภาพไฟรถ</p>
                            </div>

                            <div class="severity-selector">
                                <div class="severity-option low selected">ปกติ</div>
                                <div class="severity-option medium">ต้องตรวจสอบ</div>
                                <div class="severity-option high">ต้องซ่อมด่วน</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">ตรวจสอบภายในรถ</h3>

                    <div class="checklist-item">
                        <input type="checkbox" class="checklist-item-checkbox" id="interior-1" checked>
                        <div class="checklist-item-content">
                            <label for="interior-1" class="checklist-item-label">ระบบเบรก</label>
                            <p class="checklist-item-desc">ตรวจสอบการทำงานของเบรกและระดับน้ำมันเบรก</p>

                            <div class="severity-selector">
                                <div class="severity-option low selected">ปกติ</div>
                                <div class="severity-option medium">ต้องตรวจสอบ</div>
                                <div class="severity-option high">ต้องซ่อมด่วน</div>
                            </div>
                        </div>
                    </div>

                    <div class="checklist-item">
                        <input type="checkbox" class="checklist-item-checkbox" id="interior-2">
                        <div class="checklist-item-content">
                            <label for="interior-2" class="checklist-item-label">ระดับน้ำมันเครื่อง</label>
                            <p class="checklist-item-desc">ตรวจสอบระดับน้ำมันเครื่องและการรั่วซึม</p>

                            <div class="photo-upload">
                                <i class="fas fa-camera"></i>
                                <p>คลิกเพื่อถ่ายภาพระดับน้ำมันเครื่อง</p>
                            </div>

                            <div class="severity-selector">
                                <div class="severity-option low">ปกติ</div>
                                <div class="severity-option medium selected">ต้องตรวจสอบ</div>
                                <div class="severity-option high">ต้องซ่อมด่วน</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">ลายเซ็นยืนยันการตรวจสอบ</h3>
                    <div class="signature-pad">
                        <div class="signature-pad-content">
                            <!-- Signature will be here -->
                        </div>
                        <p class="signature-pad-label">ลายเซ็นของผู้ตรวจสอบ</p>
                    </div>
                </div>

                <div class="submit-section">
                    <button class="button-secondary">บันทึกฉบับร่าง</button>
                    <button class="button-primary">ส่งแบบฟอร์
                        มตรวจสอบ</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
