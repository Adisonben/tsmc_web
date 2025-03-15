<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Safety Manager - ติดตามและตรวจสอบงาน</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Sarabun', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
        }

        .navbar {
            background-color: #1a237e;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .container {
            padding: 1.5rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #1a237e;
        }

        .dashboard-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-col {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: #f5f7fa;
            padding: 1rem;
            font-weight: bold;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-content {
            padding: 1rem;
        }

        .live-map {
            height: 400px;
            background-color: #e5e5e5;
            position: relative;
        }

        .map-overlay {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 0.5rem;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .vehicle-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            border-radius: 4px;
        }

        .vehicle-status {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-active {
            background-color: #4caf50;
        }

        .status-idle {
            background-color: #ffc107;
        }

        .status-issue {
            background-color: #f44336;
        }

        .progress-timeline {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .timeline-item {
            display: flex;
            gap: 1rem;
        }

        .timeline-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .timeline-dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: #bbdefb;
            border: 3px solid #1976d2;
        }

        .timeline-line {
            width: 2px;
            flex-grow: 1;
            background-color: #1976d2;
            margin: 4px 0;
        }

        .timeline-content {
            flex-grow: 1;
            padding-bottom: 1rem;
        }

        .timeline-complete .timeline-dot {
            background-color: #1976d2;
        }

        .issue-item {
            display: flex;
            padding: 0.75rem;
            border-bottom: 1px solid #e0e0e0;
            gap: 1rem;
            align-items: center;
        }

        .issue-item:last-child {
            border-bottom: none;
        }

        .severity-indicator {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
            color: white;
        }

        .severity-high {
            background-color: #f44336;
        }

        .severity-medium {
            background-color: #ff9800;
        }

        .severity-low {
            background-color: #4caf50;
        }

        .chat-content {
            max-height: 300px;
            overflow-y: auto;
        }

        .message {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .message-sender {
            font-size: 0.8rem;
            color: #757575;
            margin-bottom: 0.25rem;
        }

        .message-bubble {
            padding: 0.75rem;
            border-radius: 8px;
            max-width: 80%;
        }

        .message-outgoing .message-bubble {
            background-color: #e3f2fd;
            align-self: flex-end;
        }

        .message-incoming .message-bubble {
            background-color: #f5f5f5;
            align-self: flex-start;
        }

        .chat-input {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 0.75rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .chat-input button {
            padding: 0.75rem 1rem;
            background-color: #1976d2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .pending-approval {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .approval-card {
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .approval-header {
            padding: 0.75rem;
            background-color: #f5f7fa;
            font-weight: bold;
            border-bottom: 1px solid #e0e0e0;
        }

        .approval-content {
            padding: 0.75rem;
        }

        .approval-footer {
            padding: 0.75rem;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #1976d2;
            color: white;
        }

        .btn-secondary {
            background-color: #f5f5f5;
            border: 1px solid #e0e0e0;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .badge-primary {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .badge-success {
            background-color: #e8f5e9;
            color: #4caf50;
        }

        .badge-warning {
            background-color: #fff8e1;
            color: #ff9800;
        }

        .badge-danger {
            background-color: #ffebee;
            color: #f44336;
        }

        .task-detail {
            display: flex;
            margin-bottom: 0.5rem;
        }

        .task-label {
            width: 120px;
            font-weight: bold;
            color: #757575;
        }

        .task-value {
            flex-grow: 1;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid #e0e0e0;
        }

        .tab {
            padding: 0.75rem 1rem;
            cursor: pointer;
        }

        .tab.active {
            border-bottom: 3px solid #1976d2;
            font-weight: bold;
            color: #1976d2;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="logo">TSM - Transport Safety Manager</div>
        <div class="navbar-right">
            <div class="user-info">
                <span>สวัสดี, คุณพิชัย</span>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="dashboard-title">ติดตามและตรวจสอบงาน</h1>

        <div class="dashboard-row">
            <div class="card">
                <div class="card-header">
                    <div>แผนที่งานที่กำลังดำเนินการ</div>
                    <div class="badge badge-primary">กำลังติดตาม 5 คัน</div>
                </div>
                <div class="live-map">
                    <img src="/api/placeholder/900/400" alt="แผนที่ GPS"
                        style="width: 100%; height: 100%; object-fit: cover;">

                    <div class="map-overlay">
                        <div style="font-weight: bold; margin-bottom: 0.5rem;">รถที่กำลังติดตาม</div>
                        <div class="vehicle-item">
                            <div class="vehicle-status status-active"></div>
                            <div>TH-4568 - รถบรรทุก 6 ล้อ</div>
                        </div>
                        <div class="vehicle-item">
                            <div class="vehicle-status status-idle"></div>
                            <div>TH-7821 - รถบรรทุก 10 ล้อ</div>
                        </div>
                        <div class="vehicle-item">
                            <div class="vehicle-status status-issue"></div>
                            <div>TH-9023 - รถตู้ขนส่ง</div>
                        </div>
                        <div class="vehicle-item">
                            <div class="vehicle-status status-active"></div>
                            <div>TH-2134 - รถบรรทุก 6 ล้อ</div>
                        </div>
                        <div class="vehicle-item">
                            <div class="vehicle-status status-active"></div>
                            <div>TH-5566 - รถตู้ขนส่ง</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-col">
                <div class="card">
                    <div class="card-header">
                        <div>ความคืบหน้าของงาน - TH-4568</div>
                        <div class="badge badge-success">กำลังดำเนินการ</div>
                    </div>
                    <div class="card-content">
                        <div class="task-detail">
                            <div class="task-label">คนขับ:</div>
                            <div class="task-value">สมชาย รักขับรถ</div>
                        </div>
                        <div class="task-detail">
                            <div class="task-label">เส้นทาง:</div>
                            <div class="task-value">กรุงเทพฯ - ระยอง</div>
                        </div>
                        <div class="task-detail">
                            <div class="task-label">เวลาเริ่มต้น:</div>
                            <div class="task-value">15 มี.ค. 2025, 08:30 น.</div>
                        </div>
                        <div class="task-detail">
                            <div class="task-label">เวลาคาดว่าถึง:</div>
                            <div class="task-value">15 มี.ค. 2025, 14:30 น.</div>
                        </div>

                        <div class="progress-timeline">
                            <div class="timeline-item timeline-complete">
                                <div class="timeline-indicator">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-line"></div>
                                </div>
                                <div class="timeline-content">
                                    <div style="font-weight: bold;">ตรวจสอบรถก่อนออกเดินทาง</div>
                                    <div style="color: #757575;">08:15 น. - เสร็จสมบูรณ์</div>
                                </div>
                            </div>
                            <div class="timeline-item timeline-complete">
                                <div class="timeline-indicator">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-line"></div>
                                </div>
                                <div class="timeline-content">
                                    <div style="font-weight: bold;">เริ่มเดินทาง</div>
                                    <div style="color: #757575;">08:30 น. - เสร็จสมบูรณ์</div>
                                </div>
                            </div>
                            <div class="timeline-item timeline-complete">
                                <div class="timeline-indicator">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-line"></div>
                                </div>
                                <div class="timeline-content">
                                    <div style="font-weight: bold;">ตรวจจุดพัก 1</div>
                                    <div style="color: #757575;">10:15 น. - เสร็จสมบูรณ์</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-indicator">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-line"></div>
                                </div>
                                <div class="timeline-content">
                                    <div style="font-weight: bold;">ตรวจจุดพัก 2</div>
                                    <div style="color: #757575;">รออัพเดต</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-indicator">
                                    <div class="timeline-dot"></div>
                                </div>
                                <div class="timeline-content">
                                    <div style="font-weight: bold;">ถึงจุดหมายปลายทาง</div>
                                    <div style="color: #757575;">รออัพเดต</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div>แผงจัดการปัญหา</div>
                        <div class="badge badge-danger">3 ปัญหาที่ต้องจัดการ</div>
                    </div>
                    <div class="card-content" style="padding: 0;">
                        <div class="issue-item">
                            <div class="severity-indicator severity-high">สูง</div>
                            <div style="flex-grow: 1;">
                                <div style="font-weight: bold;">ยางรั่ว - TH-9023</div>
                                <div style="color: #757575; font-size: 0.9rem;">รายงานเมื่อ 09:45 น.</div>
                            </div>
                            <button class="btn btn-primary">จัดการ</button>
                        </div>
                        <div class="issue-item">
                            <div class="severity-indicator severity-medium">กลาง</div>
                            <div style="flex-grow: 1;">
                                <div style="font-weight: bold;">น้ำมันเหลือน้อย - TH-7821</div>
                                <div style="color: #757575; font-size: 0.9rem;">รายงานเมื่อ 10:15 น.</div>
                            </div>
                            <button class="btn btn-primary">จัดการ</button>
                        </div>
                        <div class="issue-item">
                            <div class="severity-indicator severity-low">ต่ำ</div>
                            <div style="flex-grow: 1;">
                                <div style="font-weight: bold;">เอกสารไม่ครบ - TH-5566</div>
                                <div style="color: #757575; font-size: 0.9rem;">รายงานเมื่อ 08:50 น.</div>
                            </div>
                            <button class="btn btn-primary">จัดการ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-row">
            <div class="card">
                <div class="card-header">
                    <div>แผงการสื่อสาร - TH-4568 (สมชาย รักขับรถ)</div>
                </div>
                <div class="card-content">
                    <div class="chat-content">
                        <div class="message message-outgoing">
                            <div class="message-sender">คุณ (08:25 น.)</div>
                            <div class="message-bubble">สมชาย เช็คความพร้อมของรถแล้วหรือยัง?</div>
                        </div>
                        <div class="message message-incoming">
                            <div class="message-sender">สมชาย (08:26 น.)</div>
                            <div class="message-bubble">เช็คเรียบร้อยแล้วครับ ทุกอย่างพร้อม</div>
                        </div>
                        <div class="message message-outgoing">
                            <div class="message-sender">คุณ (08:28 น.)</div>
                            <div class="message-bubble">ดีมาก อย่าลืมส่งรูปตอนตรวจเช็คจุดพักด้วยนะ</div>
                        </div>
                        <div class="message message-incoming">
                            <div class="message-sender">สมชาย (08:29 น.)</div>
                            <div class="message-bubble">ได้ครับ จะส่งให้ทุกจุดพัก</div>
                        </div>
                        <div class="message message-incoming">
                            <div class="message-sender">สมชาย (10:15 น.)</div>
                            <div class="message-bubble">ถึงจุดพักแรกแล้วครับ ส่งรูปตรวจเช็คให้แล้วในระบบ</div>
                        </div>
                        <div class="message message-outgoing">
                            <div class="message-sender">คุณ (10:17 น.)</div>
                            <div class="message-bubble">ได้รับแล้ว เดินทางปลอดภัยนะ</div>
                        </div>
                    </div>
                    <div class="chat-input">
                        <input type="text" placeholder="พิมพ์ข้อความ...">
                        <button>ส่ง</button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>แดชบอร์ดตรวจสอบ</div>
                    <div class="badge badge-warning">3 งานรอการอนุมัติ</div>
                </div>
                <div class="card-content">
                    <div class="tabs">
                        <div class="tab active">รออนุมัติ (3)</div>
                        <div class="tab">อนุมัติแล้ว</div>
                        <div class="tab">ขอการแก้ไข</div>
                    </div>
                    <div style="padding: 1rem;">
                        <div class="approval-card" style="margin-bottom: 1rem;">
                            <div class="approval-header">TH-1234 - สมศักดิ์ ขับรถดี - กรุงเทพฯ-ชลบุรี</div>
                            <div class="approval-content">
                                <div class="task-detail">
                                    <div class="task-label">สถานะ:</div>
                                    <div class="task-value">เสร็จสิ้น รอการอนุมัติ</div>
                                </div>
                                <div class="task-detail">
                                    <div class="task-label">ส่งเมื่อ:</div>
                                    <div class="task-value">14 มี.ค. 2025, 16:45 น.</div>
                                </div>
                                <div class="task-detail">
                                    <div class="task-label">หลักฐาน:</div>
                                    <div class="task-value">6 รูปภาพ, 1 เอกสาร</div>
                                </div>
                            </div>
                            <div class="approval-footer">
                                <button class="btn btn-primary">ตรวจสอบ</button>
                                <button class="btn btn-secondary">ขอข้อมูลเพิ่ม</button>
                            </div>
                        </div>

                        <div class="approval-card" style="margin-bottom: 1rem;">
                            <div class="approval-header">TH-5678 - วิชัย ขับเก่ง - กรุงเทพฯ-นครราชสีมา</div>
                            <div class="approval-content">
                                <div class="task-detail">
                                    <div class="task-label">สถานะ:</div>
                                    <div class="task-value">เสร็จสิ้น รอการอนุมัติ</div>
                                </div>
                                <div class="task-detail">
                                    <div class="task-label">ส่งเมื่อ:</div>
                                    <div class="task-value">15 มี.ค. 2025, 08:30 น.</div>
                                </div>
                                <div class="task-detail">
                                    <div class="task-label">หลักฐาน:</div>
                                    <div class="task-value">8 รูปภาพ, 2 เอกสาร</div>
                                </div>
                            </div>
                            <div class="approval-footer">
                                <button class="btn btn-primary">ตรวจสอบ</button>
                                <button class="btn btn-secondary">ขอข้อมูลเพิ่ม</button>
                            </div>
                        </div>

                        <div class="approval-card">
                            <div class="approval-header">TH-9012 - มานะ ใจเย็น - กรุงเทพฯ-เชียงใหม่</div>
                            <div class="approval-content">
                                <div class="task-detail">
                                    <div class="task-label">สถานะ:</div>
                                    <div class="task-value">เสร็จสิ้น รอการอนุมัติ</div>
                                </div>
                                <div class="task-detail">
                                    <div class="task-label">ส่งเมื่อ:</div>
                                    <div class="task-value">15 มี.ค. 2025, 09:15 น.</div>
                                </div>
                                <div class="task-detail">
                                    <div class="task-label">หลักฐาน:</div>
                                    <div class="task-value">10 รูปภาพ, 3 เอกสาร</div>
                                </div>
                            </div>
                            <div class="approval-footer">
                                <button class="btn btn-primary">ตรวจสอบ</button>
                                <button class="btn btn-secondary">ขอข้อมูลเพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-row">
            <div class="card">
                <div class="card-header">
                    <div>อินเตอร์เฟซอนุมัติงาน - TH-1234</div>
                </div>
                <div class="card-content">
                    <div class="task-detail">
                        <div class="task-label">พนักงานขับรถ:</div>
                        <div class="task-value">สมศักดิ์ ขับรถดี</div>
                    </div>
                    <div class="task-detail">
                        <div class="task-label">เส้นทาง:</div>
                        <div class="task-value">กรุงเทพฯ-ชลบุรี</div>
                    </div>
                    <div class="task-detail">
                        <div class="task-label">เวลาเริ่มต้น:</div>
                        <div class="task-value">14 มี.ค. 2025, 08:30 น.</div>
                    </div>
                    <div class="task-detail">
                        <div class="task-label">เวลาสิ้นสุด:</div>
                        <div class="task-value">14 มี.ค. 2025, 16:45 น.</div>
                    </div>

                    <div style="margin: 1rem 0;">
                        <div style="font-weight: bold; margin-bottom: 0.5rem;">รายการตรวจสอบ</div>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            <div
                                style="border: 1px solid #e0e0e0; border-radius: 4px; padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; border-radius: 50%; background-color: #4caf50;">
                                </div>
                                <div>ตรวจสอบรถก่อนออกเดินทาง</div>
                            </div>
                            <div
                                style="border: 1px solid #e0e0e0; border-radius: 4px; padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; border-radius: 50%; background-color: #4caf50;">
                                </div>
                                <div>ตรวจสอบจุดพัก 1</div>
                            </div>
                            <div
                                style="border: 1px solid #e0e0e0; border-radius: 4px; padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; border-radius: 50%; background-color: #4caf50;">
                                </div>
                                <div>ตรวจสอบจุดพัก 2</div>
                            </div>
                            <div
                                style="border: 1px solid #e0e0e0; border-radius: 4px; padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; border-radius: 50%; background-color: #4caf50;">
                                </div>
                                <div>ส่งมอบสินค้า</div>
                            </div>
                            <div
                                style="border: 1px solid #e0e0e0; border-radius: 4px; padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 16px; height: 16px; border-radius: 50%; background-color: #4caf50;">
                                </div>
                                <div>ส่งมอบสินค้า</div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                        <button class="btn btn-primary">อนุมัติ</button>
                        <button class="btn btn-danger">ปฏิเสธ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
