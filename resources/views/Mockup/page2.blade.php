<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transport Safety Manager - Dashboard</title>
  <style>
    /* Base Styles */
    :root {
      --primary: #1a73e8;
      --primary-dark: #0d47a1;
      --secondary: #4caf50;
      --danger: #f44336;
      --warning: #ff9800;
      --success: #4caf50;
      --light: #f5f5f5;
      --dark: #333333;
      --gray: #757575;
      --border-radius: 8px;
      --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Prompt', sans-serif;
    }

    body {
      background-color: #f5f7fa;
      color: var(--dark);
      line-height: 1.6;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 15px;
    }

    /* Header */
    .header {
      background-color: white;
      box-shadow: var(--shadow);
      padding: 15px 0;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      font-size: 24px;
      font-weight: bold;
      color: var(--primary);
    }

    .logo i {
      margin-right: 10px;
      font-size: 28px;
    }

    .user-nav {
      display: flex;
      align-items: center;
    }

    .user-nav .notification {
      position: relative;
      margin-right: 20px;
      cursor: pointer;
    }

    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: var(--danger);
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 12px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .user-profile {
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .user-profile img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color: var(--primary-dark);
      color: white;
      height: calc(100vh - 70px);
      position: fixed;
      padding-top: 20px;
    }

    .menu-item {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: all 0.3s;
    }

    .menu-item i {
      margin-right: 10px;
      font-size: 20px;
    }

    .menu-item:hover, .menu-item.active {
      background-color: rgba(255, 255, 255, 0.1);
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 30px;
    }

    .page-title {
      margin-bottom: 25px;
      font-size: 24px;
      font-weight: 600;
    }

    /* Quick Action Buttons */
    .quick-actions {
      display: flex;
      gap: 15px;
      margin-bottom: 30px;
    }

    .action-btn {
      flex: 1;
      padding: 12px 15px;
      border-radius: var(--border-radius);
      background-color: white;
      box-shadow: var(--shadow);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
      font-weight: 500;
    }

    .action-btn i {
      margin-right: 10px;
      font-size: 20px;
    }

    .action-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .action-btn.primary {
      background-color: var(--primary);
      color: white;
    }

    .action-btn.secondary {
      background-color: var(--secondary);
      color: white;
    }

    /* Dashboard Widgets */
    .widgets-container {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }

    .widget {
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 20px;
      overflow: hidden;
    }

    .widget-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .widget-title {
      font-size: 18px;
      font-weight: 500;
    }

    .widget-actions {
      display: flex;
      gap: 10px;
    }

    .widget-actions button {
      border: none;
      background: none;
      cursor: pointer;
      color: var(--gray);
    }

    /* Work Overview Widget */
    .work-overview {
      grid-column: span 4;
    }

    .status-cards {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
    }

    .status-card {
      padding: 15px;
      border-radius: var(--border-radius);
      text-align: center;
    }

    .status-card.ongoing {
      background-color: rgba(26, 115, 232, 0.1);
      border-left: 4px solid var(--primary);
    }

    .status-card.pending {
      background-color: rgba(255, 152, 0, 0.1);
      border-left: 4px solid var(--warning);
    }

    .status-card.completed {
      background-color: rgba(76, 175, 80, 0.1);
      border-left: 4px solid var(--success);
    }

    .status-card .status-value {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .status-card .status-label {
      font-size: 14px;
      color: var(--gray);
    }

    /* Alerts Widget */
    .alerts-widget {
      grid-column: span 4;
    }

    .alert-item {
      display: flex;
      align-items: center;
      padding: 12px 0;
      border-bottom: 1px solid #eee;
    }

    .alert-item:last-child {
      border-bottom: none;
    }

    .alert-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      flex-shrink: 0;
    }

    .alert-icon.high {
      background-color: rgba(244, 67, 54, 0.1);
      color: var(--danger);
    }

    .alert-icon.medium {
      background-color: rgba(255, 152, 0, 0.1);
      color: var(--warning);
    }

    .alert-content {
      flex-grow: 1;
    }

    .alert-title {
      font-weight: 500;
      margin-bottom: 3px;
    }

    .alert-meta {
      font-size: 12px;
      color: var(--gray);
    }

    .alert-actions {
      margin-left: 10px;
    }

    /* Vehicle Status Widget */
    .vehicle-status {
      grid-column: span 4;
    }

    .vehicle-list {
      max-height: 300px;
      overflow-y: auto;
    }

    .vehicle-item {
      display: flex;
      padding: 12px 0;
      border-bottom: 1px solid #eee;
    }

    .vehicle-item:last-child {
      border-bottom: none;
    }

    .vehicle-info {
      flex-grow: 1;
    }

    .vehicle-id {
      font-weight: 500;
      margin-bottom: 3px;
    }

    .vehicle-type {
      font-size: 12px;
      color: var(--gray);
    }

    .vehicle-status-indicator {
      display: flex;
      align-items: center;
    }

    .status-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 5px;
    }

    .status-dot.available {
      background-color: var(--success);
    }

    .status-dot.in-use {
      background-color: var(--primary);
    }

    .status-dot.maintenance {
      background-color: var(--warning);
    }

    .status-dot.unavailable {
      background-color: var(--danger);
    }

    /* Driver Status Widget */
    .driver-status {
      grid-column: span 8;
    }

    .driver-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .driver-card {
      background-color: #f9f9f9;
      border-radius: var(--border-radius);
      padding: 15px;
      display: flex;
      align-items: center;
    }

    .driver-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 15px;
      object-fit: cover;
    }

    .driver-info {
      flex-grow: 1;
    }

    .driver-name {
      font-weight: 500;
      margin-bottom: 3px;
    }

    .driver-assignment {
      font-size: 12px;
      color: var(--gray);
    }

    .driver-status-badge {
      padding: 4px 8px;
      border-radius: 20px;
      font-size: 12px;
      margin-left: 10px;
    }

    .driver-status-badge.active {
      background-color: rgba(76, 175, 80, 0.1);
      color: var(--success);
    }

    .driver-status-badge.on-break {
      background-color: rgba(255, 152, 0, 0.1);
      color: var(--warning);
    }

    /* Responsive */
    @media (max-width: 1200px) {
      .widgets-container {
        grid-template-columns: repeat(6, 1fr);
      }

      .work-overview, .alerts-widget, .vehicle-status {
        grid-column: span 6;
      }

      .driver-status {
        grid-column: span 6;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }

      .menu-item span {
        display: none;
      }

      .menu-item i {
        margin-right: 0;
      }

      .main-content {
        margin-left: 70px;
      }

      .quick-actions {
        flex-wrap: wrap;
      }

      .action-btn {
        min-width: 45%;
      }
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="container header-container">
      <div class="logo">
        <i class="fas fa-truck-moving"></i>
        <span>Transport Safety Manager</span>
      </div>
      <div class="user-nav">
        <div class="notification">
          <i class="far fa-bell fa-lg"></i>
          <span class="notification-badge">5</span>
        </div>
        <div class="user-profile">
          <img src="/api/placeholder/40/40" alt="User Profile">
          <span>สมชาย ใจดี</span>
        </div>
      </div>
    </div>
  </header>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="menu-item active">
      <i class="fas fa-home"></i>
      <span>หน้าหลัก</span>
    </div>
    <div class="menu-item">
      <i class="fas fa-tasks"></i>
      <span>จัดการงาน</span>
    </div>
    <div class="menu-item">
      <i class="fas fa-truck"></i>
      <span>ยานพาหนะ</span>
    </div>
    <div class="menu-item">
      <i class="fas fa-users"></i>
      <span>พนักงานขับรถ</span>
    </div>
    <div class="menu-item">
      <i class="fas fa-route"></i>
      <span>เส้นทาง</span>
    </div>
    <div class="menu-item">
      <i class="fas fa-chart-bar"></i>
      <span>รายงาน</span>
    </div>
    <div class="menu-item">
      <i class="fas fa-cog"></i>
      <span>ตั้งค่า</span>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h1 class="page-title">แดชบอร์ด</h1>

    <!-- Quick Action Buttons -->
    <div class="quick-actions">
      <div class="action-btn primary">
        <i class="fas fa-plus"></i>
        <span>สร้างงานใหม่</span>
      </div>
      <div class="action-btn">
        <i class="fas fa-file-alt"></i>
        <span>ออกรายงาน</span>
      </div>
      <div class="action-btn">
        <i class="fas fa-cog"></i>
        <span>การตั้งค่า</span>
      </div>
    </div>

    <!-- Widgets -->
    <div class="widgets-container">
      <!-- Work Overview Widget -->
      <div class="widget work-overview">
        <div class="widget-header">
          <h2 class="widget-title">ภาพรวมงาน</h2>
          <div class="widget-actions">
            <button><i class="fas fa-sync-alt"></i></button>
            <button><i class="fas fa-ellipsis-v"></i></button>
          </div>
        </div>
        <div class="status-cards">
          <div class="status-card ongoing">
            <div class="status-value">12</div>
            <div class="status-label">กำลังดำเนินการ</div>
          </div>
          <div class="status-card pending">
            <div class="status-value">8</div>
            <div class="status-label">รอดำเนินการ</div>
          </div>
          <div class="status-card completed">
            <div class="status-value">45</div>
            <div class="status-label">เสร็จสิ้น</div>
          </div>
        </div>
      </div>

      <!-- Alerts Widget -->
      <div class="widget alerts-widget">
        <div class="widget-header">
          <h2 class="widget-title">การแจ้งเตือน</h2>
          <div class="widget-actions">
            <button><i class="fas fa-sync-alt"></i></button>
            <button><i class="fas fa-ellipsis-v"></i></button>
          </div>
        </div>
        <div class="alerts-list">
          <div class="alert-item">
            <div class="alert-icon high">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
              <div class="alert-title">รถบรรทุก ท-1234 แจ้งเหตุฉุกเฉิน</div>
              <div class="alert-meta">10 นาทีที่ผ่านมา · ถนนพหลโยธิน กม.52</div>
            </div>
            <div class="alert-actions">
              <button><i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
          <div class="alert-item">
            <div class="alert-icon high">
              <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
              <div class="alert-title">พนักงานขับรถเกินเวลาทำงาน</div>
              <div class="alert-meta">45 นาทีที่ผ่านมา · นายวิชัย สุขสบาย</div>
            </div>
            <div class="alert-actions">
              <button><i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
          <div class="alert-item">
            <div class="alert-icon medium">
              <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="alert-content">
              <div class="alert-title">รถบรรทุก ท-5678 ถึงกำหนดตรวจสภาพ</div>
              <div class="alert-meta">3 ชั่วโมงที่ผ่านมา</div>
            </div>
            <div class="alert-actions">
              <button><i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
      </div>

      <!-- Vehicle Status Widget -->
      <div class="widget vehicle-status">
        <div class="widget-header">
          <h2 class="widget-title">สถานะกองยานพาหนะ</h2>
          <div class="widget-actions">
            <button><i class="fas fa-sync-alt"></i></button>
            <button><i class="fas fa-ellipsis-v"></i></button>
          </div>
        </div>
        <div class="vehicle-list">
          <div class="vehicle-item">
            <div class="vehicle-info">
              <div class="vehicle-id">รถบรรทุก ท-1234</div>
              <div class="vehicle-type">บรรทุก 6 ล้อ · GPS Online</div>
            </div>
            <div class="vehicle-status-indicator">
              <div class="status-dot in-use"></div>
              <span>กำลังใช้งาน</span>
            </div>
          </div>
          <div class="vehicle-item">
            <div class="vehicle-info">
              <div class="vehicle-id">รถบรรทุก ท-5678</div>
              <div class="vehicle-type">บรรทุก 10 ล้อ · GPS Online</div>
            </div>
            <div class="vehicle-status-indicator">
              <div class="status-dot maintenance"></div>
              <span>ซ่อมบำรุง</span>
            </div>
          </div>
          <div class="vehicle-item">
            <div class="vehicle-info">
              <div class="vehicle-id">รถบรรทุก ท-9012</div>
              <div class="vehicle-type">บรรทุก 6 ล้อ · GPS Online</div>
            </div>
            <div class="vehicle-status-indicator">
              <div class="status-dot available"></div>
              <span>พร้อมใช้งาน</span>
            </div>
          </div>
          <div class="vehicle-item">
            <div class="vehicle-info">
              <div class="vehicle-id">รถบรรทุก ท-3456</div>
              <div class="vehicle-type">บรรทุก 10 ล้อ · GPS Offline</div>
            </div>
            <div class="vehicle-status-indicator">
              <div class="status-dot unavailable"></div>
              <span>ไม่พร้อมใช้งาน</span>
            </div>
          </div>
          <div class="vehicle-item">
            <div class="vehicle-info">
              <div class="vehicle-id">รถบรรทุก ท-7890</div>
              <div class="vehicle-type">บรรทุก 6 ล้อ · GPS Online</div>
            </div>
            <div class="vehicle-status-indicator">
              <div class="status-dot in-use"></div>
              <span>กำลังใช้งาน</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Driver Status Widget -->
      <div class="widget driver-status">
        <div class="widget-header">
          <h2 class="widget-title">สถานะพนักงานขับรถ</h2>
          <div class="widget-actions">
            <button><i class="fas fa-sync-alt"></i></button>
            <button><i class="fas fa-ellipsis-v"></i></button>
          </div>
        </div>
        <div class="driver-grid">
          <div class="driver-card">
            <img src="/api/placeholder/50/50" alt="Driver" class="driver-avatar">
            <div class="driver-info">
              <div class="driver-name">นายสมชาย รักดี</div>
              <div class="driver-assignment">งาน: ขนส่งสินค้า กรุงเทพฯ-ระยอง</div>
            </div>
            <div class="driver-status-badge active">ทำงาน</div>
          </div>
          <div class="driver-card">
            <img src="/api/placeholder/50/50" alt="Driver" class="driver-avatar">
            <div class="driver-info">
              <div class="driver-name">นายวิชัย สุขสบาย</div>
              <div class="driver-assignment">งาน: ขนส่งสินค้า กรุงเทพฯ-ชลบุรี</div>
            </div>
            <div class="driver-status-badge active">ทำงาน</div>
          </div>
          <div class="driver-card">
            <img src="/api/placeholder/50/50" alt="Driver" class="driver-avatar">
            <div class="driver-info">
              <div class="driver-name">นายสมศักดิ์ ใจเย็น</div>
              <div class="driver-assignment">งาน: จัดส่งพัสดุในกรุงเทพฯ</div>
            </div>
            <div class="driver-status-badge on-break">พัก</div>
          </div>
          <div class="driver-card">
            <img src="/api/placeholder/50/50" alt="Driver" class="driver-avatar">
            <div class="driver-info">
              <div class="driver-name">นายมานะ อดทน</div>
              <div class="driver-assignment">งาน: รอรับมอบหมาย</div>
            </div>
            <div class="driver-status-badge active">ทำงาน</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
