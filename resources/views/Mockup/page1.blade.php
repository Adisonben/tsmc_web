<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Safety Manager - Dashboard</title>

    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #3366cc;
            --primary-light: #e8f0ff;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --gray-light: #f8f9fa;
            --gray: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .sidebar-menu {
            margin-top: 20px;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(255,255,255,0.1);
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .action-btn {
            padding: 10px 20px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .action-btn i {
            margin-right: 8px;
        }

        .action-btn.success {
            background-color: var(--success);
        }

        /* Dashboard Cards */
        .dashboard-overview {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 20px;
        }

        .stat-card {
            position: relative;
        }

        .stat-card .card-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-light);
            color: var(--primary);
            border-radius: 8px;
            font-size: 24px;
        }

        .stat-card h3 {
            font-size: 14px;
            color: var(--gray);
            margin-bottom: 10px;
        }

        .stat-card .stat-value {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-card .stat-change {
            font-size: 12px;
            color: var(--success);
        }

        /* Task Listings */
        .tasks-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .card-title {
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title .view-all {
            font-size: 12px;
            color: var(--primary);
            cursor: pointer;
        }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .task-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 4px;
            background-color: var(--gray-light);
            cursor: pointer;
        }

        .task-item:hover {
            background-color: #edf2ff;
        }

        .task-priority {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .priority-normal {
            background-color: var(--success);
        }

        .priority-urgent {
            background-color: var(--warning);
        }

        .priority-emergency {
            background-color: var(--danger);
        }

        .task-info {
            flex: 1;
        }

        .task-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .task-details {
            display: flex;
            gap: 10px;
            font-size: 12px;
            color: var(--gray);
        }

        .task-status {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-in-progress {
            background-color: #CCE5FF;
            color: #004085;
        }

        .status-completed {
            background-color: #D4EDDA;
            color: #155724;
        }

        /* Map container */
        .map-container {
            height: 400px;
            background-color: #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .map-container::after {
            content: "แผนที่แสดงตำแหน่งของยานพาหนะ";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #333;
            font-weight: 500;
        }

        /* Alert Section */
        .alerts {
            margin-top: 20px;
        }

        .alert-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 4px;
            background-color: #FFEBEE;
            border-left: 4px solid var(--danger);
            margin-bottom: 10px;
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger);
            border-radius: 8px;
            margin-right: 15px;
            font-size: 20px;
        }

        .alert-info {
            flex: 1;
        }

        .alert-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .alert-desc {
            font-size: 12px;
            color: var(--gray);
        }

        .alert-actions {
            margin-left: 10px;
        }

        #map { height: 500px; width: 100%; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <div style="width:40px;height:40px;background:#3366cc;border-radius:8px;margin-right:10px;display:flex;align-items:center;justify-content:center;color:white;">TSM</div>
                <span>Transport Safety Manager</span>
            </div>

            <div class="sidebar-menu">
                <div class="menu-item active">
                    <i>📊</i> แดชบอร์ด
                </div>
                <div class="menu-item">
                    <i>🚗</i> จัดการยานพาหนะ
                </div>
                <div class="menu-item">
                    <i>👨‍✈️</i> จัดการพนักงานขับรถ
                </div>
                <div class="menu-item">
                    <i>📝</i> สร้างงานใหม่
                </div>
                <div class="menu-item">
                    <i>📊</i> รายงานและวิเคราะห์
                </div>
                <div class="menu-item">
                    <i>⚙️</i> ตั้งค่าระบบ
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="page-title">แดชบอร์ด</div>
                <div class="user-info">
                    <span>สวัสดี, คุณจักรพงษ์</span>
                    <img src="/api/placeholder/40/40" alt="User Profile">
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="action-btn success">
                    <i>➕</i> สร้างงานใหม่
                </button>
                <button class="action-btn">
                    <i>📊</i> รายงาน
                </button>
                <button class="action-btn">
                    <i>🚨</i> แจ้งเตือน
                </button>
            </div>

            <!-- Dashboard Overview -->
            <div class="dashboard-overview">
                <div class="card stat-card">
                    <div class="card-icon">🚗</div>
                    <h3>ยานพาหนะทั้งหมด</h3>
                    <div class="stat-value">32</div>
                    <div class="stat-change">+2 เมื่อเทียบกับเดือนที่แล้ว</div>
                </div>

                <div class="card stat-card">
                    <div class="card-icon">👨‍✈️</div>
                    <h3>พนักงานขับรถ</h3>
                    <div class="stat-value">48</div>
                    <div class="stat-change">+5 เมื่อเทียบกับเดือนที่แล้ว</div>
                </div>

                <div class="card stat-card">
                    <div class="card-icon">📝</div>
                    <h3>งานกำลังดำเนินการ</h3>
                    <div class="stat-value">12</div>
                    <div class="stat-change">-3 เมื่อเทียบกับสัปดาห์ที่แล้ว</div>
                </div>

                <div class="card stat-card">
                    <div class="card-icon">✅</div>
                    <h3>งานเสร็จสิ้นวันนี้</h3>
                    <div class="stat-value">8</div>
                    <div class="stat-change">+2 เมื่อเทียบกับเมื่อวาน</div>
                </div>
            </div>

            <!-- Map View -->
            <div class="card">
                <div class="card-title">
                    <span>แผนที่แสดงตำแหน่งยานพาหนะ</span>
                    <span class="view-all">ขยาย</span>
                </div>
                <div class="map-container">
                    <div id="map"></div>
                </div>
            </div>

            <!-- Tasks Lists -->
            <div class="tasks-container">
                <div class="card">
                    <div class="card-title">
                        <span>งานที่กำลังดำเนินการ</span>
                        <span class="view-all">ดูทั้งหมด</span>
                    </div>
                    <div class="task-list">
                        <div class="task-item">
                            <div class="task-priority priority-urgent"></div>
                            <div class="task-info">
                                <div class="task-title">ขนส่งสินค้าไปคลังสินค้าจังหวัดชลบุรี</div>
                                <div class="task-details">
                                    <span>🚗 รถบรรทุก 6 ล้อ</span>
                                    <span>👨‍✈️ นายสมชาย ใจดี</span>
                                </div>
                            </div>
                            <div class="task-status status-in-progress">กำลังดำเนินการ</div>
                        </div>

                        <div class="task-item">
                            <div class="task-priority priority-normal"></div>
                            <div class="task-info">
                                <div class="task-title">ขนส่งอุปกรณ์ก่อสร้างไปโครงการบางนา</div>
                                <div class="task-details">
                                    <span>🚗 รถบรรทุก 10 ล้อ</span>
                                    <span>👨‍✈️ นายวิชัย รักดี</span>
                                </div>
                            </div>
                            <div class="task-status status-in-progress">กำลังดำเนินการ</div>
                        </div>

                        <div class="task-item">
                            <div class="task-priority priority-emergency"></div>
                            <div class="task-info">
                                <div class="task-title">ขนส่งสินค้าแช่แข็งไปห้างสรรพสินค้า</div>
                                <div class="task-details">
                                    <span>🚗 รถห้องเย็น</span>
                                    <span>👨‍✈️ นายพิชิต ใจกล้า</span>
                                </div>
                            </div>
                            <div class="task-status status-in-progress">กำลังดำเนินการ</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-title">
                        <span>งานที่รอตรวจสอบ</span>
                        <span class="view-all">ดูทั้งหมด</span>
                    </div>
                    <div class="task-list">
                        <div class="task-item">
                            <div class="task-priority priority-normal"></div>
                            <div class="task-info">
                                <div class="task-title">ส่งของไปศูนย์กระจายสินค้านครราชสีมา</div>
                                <div class="task-details">
                                    <span>🚗 รถบรรทุกเล็ก</span>
                                    <span>👨‍✈️ นายชาติชาย ชาญชัย</span>
                                </div>
                            </div>
                            <div class="task-status status-completed">เสร็จสิ้น</div>
                        </div>

                        <div class="task-item">
                            <div class="task-priority priority-urgent"></div>
                            <div class="task-info">
                                <div class="task-title">ขนส่งวัตถุดิบไปโรงงานพระราม 2</div>
                                <div class="task-details">
                                    <span>🚗 รถบรรทุก 6 ล้อ</span>
                                    <span>👨‍✈️ นายสมศักดิ์ มั่นคง</span>
                                </div>
                            </div>
                            <div class="task-status status-completed">เสร็จสิ้น</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts Section -->
            <div class="alerts">
                <div class="card-title">
                    <span>การแจ้งเตือนล่าสุด</span>
                    <span class="view-all">ดูทั้งหมด</span>
                </div>

                <div class="alert-item">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-info">
                        <div class="alert-title">พบความผิดปกติของพฤติกรรมการขับขี่</div>
                        <div class="alert-desc">นายสมชาย ใจดี พบการขับรถเร็วเกินกำหนด 3 ครั้งในเส้นทางปัจจุบัน</div>
                    </div>
                    <div class="alert-actions">
                        <button style="padding:5px 10px;background:#dc3545;color:white;border:none;border-radius:4px;">ดูรายละเอียด</button>
                    </div>
                </div>

                <div class="alert-item">
                    <div class="alert-icon">⚠️</div>
                    <div class="alert-info">
                        <div class="alert-title">รถบรรทุกต้องการการซ่อมบำรุง</div>
                        <div class="alert-desc">รถบรรทุก 10 ล้อ ทะเบียน กท-1234 ถึงกำหนดตรวจเช็คระบบเบรค</div>
                    </div>
                    <div class="alert-actions">
                        <button style="padding:5px 10px;background:#dc3545;color:white;border:none;border-radius:4px;">ดูรายละเอียด</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet.js JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialize the map and set its view
        const map = L.map('map').setView([13.7563, 100.5018], 10); // Bangkok, Thailand

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        map.locate({setView: true, maxZoom: 16});

        var truckIcon = L.divIcon({
            html: '<i class="fas fa-truck" style="font-size:24px; color:blue;"></i>',
            className: 'custom-div-icon',
            iconSize: [30, 30]
        });

        // Add a marker
        L.marker([13.7563, 100.5018], { icon: truckIcon }).addTo(map)
            .bindPopup("Bangkok, Thailand")
            .openPopup();

        function onLocationFound(e) {
            var radius = e.accuracy;

            L.marker(e.latlng, { icon: truckIcon }).addTo(map).bindPopup("You are within " + radius + " meters from this point").openPopup();

            L.circle(e.latlng, radius).addTo(map);
        }

        function onLocationError(e) {
            alert(e.message);
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        // L.marker([13.7563, 100.5018], { icon: truckIcon }).addTo(map);


    </script>
</body>
</html>
