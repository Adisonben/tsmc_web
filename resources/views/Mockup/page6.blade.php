<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TSM - ศูนย์วิเคราะห์และรายงาน</title>
  <style>
    body {
      font-family: 'Sarabun', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f7fa;
      color: #333;
    }

    .navbar {
      background-color: #2c3e50;
      padding: 1rem;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .navbar h1 {
      margin: 0;
      font-size: 1.2rem;
    }

    .navbar-menu {
      display: flex;
      gap: 1.5rem;
    }

    .navbar-menu a {
      color: white;
      text-decoration: none;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      background-color: #3498db;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
    }

    .container {
      padding: 1rem;
      max-width: 1600px;
      margin: 0 auto;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .card {
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      padding: 1.5rem;
      height: 100%;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      padding-bottom: 0.5rem;
      border-bottom: 1px solid #eee;
    }

    .card-title {
      font-size: 1.1rem;
      margin: 0;
      font-weight: 600;
    }

    .card-options {
      color: #7f8c8d;
      font-size: 1.2rem;
    }

    .large-card {
      grid-column: span 2;
    }

    .metric-container {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .metric-box {
      background-color: #f8f9fa;
      border-radius: 6px;
      padding: 1rem;
      flex: 1;
      min-width: 140px;
      text-align: center;
    }

    .metric-value {
      font-size: 1.8rem;
      font-weight: bold;
      margin-bottom: 0.25rem;
    }

    .metric-label {
      font-size: 0.85rem;
      color: #7f8c8d;
    }

    .chart-container {
      height: 250px;
      position: relative;
    }

    .chart-placeholder {
      width: 100%;
      height: 100%;
      background-color: #f8f9fa;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #7f8c8d;
    }

    .heatmap-container {
      height: 300px;
      background-color: #f8f9fa;
      border-radius: 6px;
      position: relative;
    }

    .compliance-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0.5rem;
    }

    .compliance-item {
      display: flex;
      align-items: center;
      padding: 0.5rem;
      border-radius: 6px;
      background-color: #f8f9fa;
    }

    .status-indicator {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 0.5rem;
    }

    .status-green {
      background-color: #2ecc71;
    }

    .status-yellow {
      background-color: #f1c40f;
    }

    .status-red {
      background-color: #e74c3c;
    }

    .report-tools {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
    }

    .tool-card {
      background-color: #f8f9fa;
      border-radius: 6px;
      padding: 1rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .tool-card:hover {
      background-color: #e9ecef;
    }

    .tool-icon {
      width: 40px;
      height: 40px;
      background-color: #3498db;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
    }

    .alert-container {
      margin-top: 2rem;
    }

    .alert-item {
      display: flex;
      align-items: center;
      padding: 1rem;
      background-color: #fef9e7;
      border-left: 4px solid #f1c40f;
      border-radius: 4px;
      margin-bottom: 0.5rem;
    }

    .alert-icon {
      margin-right: 1rem;
      color: #f1c40f;
      font-size: 1.2rem;
    }

    .button {
      padding: 0.5rem 1rem;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9rem;
    }

    .button:hover {
      background-color: #2980b9;
    }

    .button-secondary {
      background-color: #ecf0f1;
      color: #7f8c8d;
    }

    .button-secondary:hover {
      background-color: #bdc3c7;
    }

    .tabs {
      display: flex;
      border-bottom: 1px solid #eee;
      margin-bottom: 1.5rem;
    }

    .tab {
      padding: 0.75rem 1rem;
      cursor: pointer;
    }

    .tab.active {
      border-bottom: 3px solid #3498db;
      color: #3498db;
      font-weight: 500;
    }

    .date-filter {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background-color: white;
      padding: 0.5rem;
      border-radius: 4px;
      border: 1px solid #eee;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <h1>Transport Safety Manager (TSM)</h1>
    <div class="navbar-menu">
      <a href="#">แดชบอร์ด</a>
      <a href="#">งาน</a>
      <a href="#">กองยานพาหนะ</a>
      <a href="#">พนักงานขับรถ</a>
      <a href="#" style="color: #3498db; font-weight: 500;">วิเคราะห์และรายงาน</a>
    </div>
    <div class="user-info">
      <span>ผู้จัดการฝ่ายความปลอดภัย</span>
      <div class="user-avatar">A</div>
    </div>
  </div>

  <div class="container">
    <div class="page-header">
      <h2>ศูนย์วิเคราะห์และรายงาน</h2>
      <div class="date-filter">
        <span>ช่วงเวลา:</span>
        <select>
          <option>วันนี้</option>
          <option>7 วันที่ผ่านมา</option>
          <option selected>30 วันที่ผ่านมา</option>
          <option>3 เดือนที่ผ่านมา</option>
          <option>กำหนดเอง</option>
        </select>
      </div>
    </div>

    <div class="tabs">
      <div class="tab active">ภาพรวม</div>
      <div class="tab">ประสิทธิภาพพนักงานขับรถ</div>
      <div class="tab">การบำรุงรักษารถ</div>
      <div class="tab">การวิเคราะห์เส้นทาง</div>
      <div class="tab">การปฏิบัติตามกฎระเบียบ</div>
      <div class="tab">รายงานแบบกำหนดเอง</div>
    </div>

    <div class="dashboard-grid">
      <!-- ตัวชี้วัดประสิทธิภาพของพนักงานขับรถ -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">ตัวชี้วัดประสิทธิภาพของพนักงานขับรถ</h3>
          <div class="card-options">⋮</div>
        </div>
        <div class="metric-container">
          <div class="metric-box">
            <div class="metric-value">89%</div>
            <div class="metric-label">คะแนนความปลอดภัยเฉลี่ย</div>
          </div>
          <div class="metric-box">
            <div class="metric-value">94%</div>
            <div class="metric-label">อัตราการปฏิบัติตาม</div>
          </div>
          <div class="metric-box">
            <div class="metric-value">6</div>
            <div class="metric-label">พนักงานที่ต้องได้รับการฝึกอบรมเพิ่มเติม</div>
          </div>
        </div>
        <div class="chart-container">
          <div class="chart-placeholder">
            [กราฟแสดงคะแนนความปลอดภัยรายบุคคล]
          </div>
        </div>
      </div>

      <!-- การคาดการณ์การบำรุงรักษารถ -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">การคาดการณ์การบำรุงรักษารถ (AI)</h3>
          <div class="card-options">⋮</div>
        </div>
        <div class="metric-container">
          <div class="metric-box">
            <div class="metric-value">8</div>
            <div class="metric-label">รถที่ต้องการบำรุงรักษาเร่งด่วน</div>
          </div>
          <div class="metric-box">
            <div class="metric-value">14</div>
            <div class="metric-label">รถที่ต้องการตรวจสอบในสัปดาห์นี้</div>
          </div>
        </div>
        <div class="chart-container">
          <div class="chart-placeholder">
            [กราฟแสดงการคาดการณ์ปัญหายานพาหนะ]
          </div>
        </div>
      </div>

      <!-- การวิเคราะห์ความเสี่ยงของเส้นทาง -->
      <div class="card large-card">
        <div class="card-header">
          <h3 class="card-title">การวิเคราะห์ความเสี่ยงของเส้นทาง</h3>
          <div class="card-options">⋮</div>
        </div>
        <div class="heatmap-container">
          <div class="chart-placeholder">
            [แผนที่ความร้อนแสดงพื้นที่ที่มีความเสี่ยง]
          </div>
        </div>
        <div class="metric-container" style="margin-top: 1rem;">
          <div class="metric-box">
            <div class="metric-value">5</div>
            <div class="metric-label">พื้นที่ความเสี่ยงสูง</div>
          </div>
          <div class="metric-box">
            <div class="metric-value">12</div>
            <div class="metric-label">รายงานสภาพถนนเสียหาย</div>
          </div>
          <div class="metric-box">
            <div class="metric-value">28%</div>
            <div class="metric-label">ลดลงจากไตรมาสที่แล้ว</div>
          </div>
        </div>
      </div>

      <!-- แดชบอร์ดการปฏิบัติตามกฎระเบียบ -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">การปฏิบัติตามกฎระเบียบ</h3>
          <div class="card-options">⋮</div>
        </div>
        <div class="compliance-grid">
          <div class="compliance-item">
            <div class="status-indicator status-green"></div>
            <span>ใบอนุญาตขับขี่</span>
          </div>
          <div class="compliance-item">
            <div class="status-indicator status-green"></div>
            <span>ประกันภัย</span>
          </div>
          <div class="compliance-item">
            <div class="status-indicator status-yellow"></div>
            <span>ตรวจสภาพยานพาหนะ</span>
          </div>
          <div class="compliance-item">
            <div class="status-indicator status-green"></div>
            <span>การฝึกอบรมความปลอดภัย</span>
          </div>
          <div class="compliance-item">
            <div class="status-indicator status-green"></div>
            <span>ชั่วโมงการขับขี่</span>
          </div>
          <div class="compliance-item">
            <div class="status-indicator status-red"></div>
            <span>เอกสารการขนส่ง</span>
          </div>
        </div>
        <div class="chart-container">
          <div class="chart-placeholder">
            [กราฟแสดงอัตราการปฏิบัติตามกฎระเบียบ]
          </div>
        </div>
      </div>

      <!-- เครื่องมือสร้างรายงานแบบกำหนดเอง -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">เครื่องมือสร้างรายงาน</h3>
          <div class="card-options">⋮</div>
        </div>
        <div class="report-tools">
          <div class="tool-card">
            <div class="tool-icon">📊</div>
            <div>
              <h4 style="margin:0 0 0.25rem 0">รายงานประจำเดือน</h4>
              <p style="margin:0; font-size:0.85rem; color:#7f8c8d">สร้างรายงานสรุปประจำเดือน</p>
            </div>
          </div>
          <div class="tool-card">
            <div class="tool-icon">🚗</div>
            <div>
              <h4 style="margin:0 0 0.25rem 0">รายงานยานพาหนะ</h4>
              <p style="margin:0; font-size:0.85rem; color:#7f8c8d">วิเคราะห์ประสิทธิภาพยานพาหนะ</p>
            </div>
          </div>
          <div class="tool-card">
            <div class="tool-icon">👤</div>
            <div>
              <h4 style="margin:0 0 0.25rem 0">รายงานพนักงาน</h4>
              <p style="margin:0; font-size:0.85rem; color:#7f8c8d">วิเคราะห์ประสิทธิภาพพนักงาน</p>
            </div>
          </div>
          <div class="tool-card">
            <div class="tool-icon">✓</div>
            <div>
              <h4 style="margin:0 0 0.25rem 0">รายงานกำหนดเอง</h4>
              <p style="margin:0; font-size:0.85rem; color:#7f8c8d">สร้างรายงานตามความต้องการ</p>
            </div>
          </div>
        </div>
      </div>

      <!-- การแจ้งเตือนอัตโนมัติ -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">การแจ้งเตือนอัจฉริยะ (AI)</h3>
          <div class="card-options">⋮</div>
        </div>
        <div class="alert-container">
          <div class="alert-item">
            <div class="alert-icon">⚠️</div>
            <div>
              <div>พบรูปแบบการเบรกกะทันหันในรถ 6 คัน</div>
              <div style="font-size: 0.85rem; color: #7f8c8d;">อาจบ่งชี้ถึงปัญหาการขับขี่หรือสภาพถนน</div>
            </div>
          </div>
          <div class="alert-item">
            <div class="alert-icon">⚠️</div>
            <div>
              <div>ชั่วโมงทำงานเกินกำหนดในพนักงาน 3 คน</div>
              <div style="font-size: 0.85rem; color: #7f8c8d;">มีความเสี่ยงต่อการไม่ปฏิบัติตามข้อกำหนด</div>
            </div>
          </div>
          <div class="alert-item">
            <div class="alert-icon">⚠️</div>
            <div>
              <div>ตรวจพบความผิดปกติในการใช้เชื้อเพลิง</div>
              <div style="font-size: 0.85rem; color: #7f8c8d;">ยานพาหนะ 4 คันมีการใช้เชื้อเพลิงสูงกว่าค่าเฉลี่ย 20%</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
