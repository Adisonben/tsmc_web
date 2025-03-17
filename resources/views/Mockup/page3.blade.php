<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transport Safety Manager - สร้างงานใหม่</title>
  <style>
    :root {
      --primary-color: #2563EB;
      --secondary-color: #F3F4F6;
      --success-color: #10B981;
      --warning-color: #F59E0B;
      --danger-color: #EF4444;
      --text-color: #1F2937;
      --light-text: #6B7280;
      --border-color: #E5E7EB;
    }

    body {
      font-family: 'Sarabun', 'Noto Sans Thai', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #F9FAFB;
      color: var(--text-color);
    }

    header {
      background-color: white;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: bold;
      font-size: 1.25rem;
      color: var(--primary-color);
    }

    .container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
    }

    .card {
      background-color: white;
      border-radius: 0.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .form-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    @media (max-width: 768px) {
      .form-grid {
        grid-template-columns: 1fr;
      }
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    input, select, textarea {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid var(--border-color);
      border-radius: 0.25rem;
      font-family: inherit;
      font-size: 1rem;
    }

    select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 0.5rem center;
      background-size: 1.5em 1.5em;
      padding-right: 2.5rem;
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
    }

    .search-select {
      position: relative;
    }

    .search-input {
      padding-left: 2.5rem;
    }

    .search-icon {
      position: absolute;
      left: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--light-text);
    }

    .status-indicator {
      display: inline-block;
      width: 0.75rem;
      height: 0.75rem;
      border-radius: 50%;
      margin-right: 0.5rem;
    }

    .available {
      background-color: var(--success-color);
    }

    .unavailable {
      background-color: var(--danger-color);
    }

    .checklist-builder {
      border: 1px solid var(--border-color);
      border-radius: 0.25rem;
      padding: 1rem;
    }

    .checklist-item {
      display: flex;
      align-items: center;
      padding: 0.5rem;
      border-bottom: 1px solid var(--border-color);
    }

    .checklist-item:last-child {
      border-bottom: none;
    }

    .checklist-item input[type="checkbox"] {
      width: auto;
      margin-right: 0.5rem;
    }

    .add-item {
      display: flex;
      margin-top: 0.5rem;
    }

    .add-item button {
      margin-left: 0.5rem;
      white-space: nowrap;
    }

    .priority-options {
      display: flex;
      gap: 1rem;
    }

    .priority-option {
      flex: 1;
      text-align: center;
      padding: 0.75rem;
      border: 2px solid var(--border-color);
      border-radius: 0.25rem;
      cursor: pointer;
      font-weight: 600;
    }

    .priority-normal {
      color: var(--success-color);
    }

    .priority-normal.active {
      background-color: rgba(16, 185, 129, 0.1);
      border-color: var(--success-color);
    }

    .priority-urgent {
      color: var(--warning-color);
    }

    .priority-urgent.active {
      background-color: rgba(245, 158, 11, 0.1);
      border-color: var(--warning-color);
    }

    .priority-emergency {
      color: var(--danger-color);
    }

    .priority-emergency.active {
      background-color: rgba(239, 68, 68, 0.1);
      border-color: var(--danger-color);
    }

    .datetime-group {
      display: flex;
      gap: 1rem;
    }

    .datetime-group .form-group {
      flex: 1;
      margin-bottom: 0;
    }

    .btn {
      display: inline-block;
      font-weight: 600;
      text-align: center;
      vertical-align: middle;
      cursor: pointer;
      padding: 0.75rem 1.5rem;
      border-radius: 0.25rem;
      border: 1px solid transparent;
      font-size: 1rem;
      line-height: 1.5;
      transition: all 0.15s ease-in-out;
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
    }

    .btn-primary:hover {
      background-color: #1D4ED8;
    }

    .btn-outline {
      background-color: transparent;
      color: var(--primary-color);
      border-color: var(--primary-color);
    }

    .btn-outline:hover {
      background-color: rgba(37, 99, 235, 0.1);
    }

    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
      margin-top: 2rem;
    }

    .submit-btn {
      padding: 0.75rem 2rem;
      font-size: 1.125rem;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 8v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8l2-4h12l2 4Z"></path>
        <path d="M2 8h20"></path>
        <path d="M12 13v7"></path>
        <path d="M12 13H8"></path>
        <path d="M12 13h4"></path>
      </svg>
      <span>Transport Safety Manager</span>
    </div>
    <div>
      <span style="margin-right: 1rem;">สวัสดี, คุณวิทยา</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
      </svg>
    </div>
  </header>

  <div class="container">
    <div class="card">
      <div class="form-title">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
        สร้างงานใหม่
      </div>

      <form>
        <div class="form-grid">
          <div class="form-group">
            <label for="vehicle">เลือกรถ</label>
            <div class="search-select">
              <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <select id="vehicle" class="search-input">
                <option value="">- เลือกรถที่พร้อมใช้งาน -</option>
                <option value="1">TH-1234 - รถบรรทุก 6 ล้อ (พร้อมใช้งาน)</option>
                <option value="2">TH-5678 - รถบรรทุก 10 ล้อ (พร้อมใช้งาน)</option>
                <option value="3">TH-9012 - รถตู้ (พร้อมใช้งาน)</option>
                <option value="4">TH-3456 - รถกระบะ (พร้อมใช้งาน)</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="driver">มอบหมายพนักงานขับรถ</label>
            <div class="search-select">
              <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
              </svg>
              <select id="driver" class="search-input">
                <option value="">- เลือกพนักงานขับรถ -</option>
                <option value="1"><span class="status-indicator available"></span>สมชาย ใจดี (ว่าง)</option>
                <option value="2"><span class="status-indicator available"></span>วิชัย รักดี (ว่าง)</option>
                <option value="3"><span class="status-indicator unavailable"></span>สมศักดิ์ มีทรัพย์ (ไม่ว่าง)</option>
                <option value="4"><span class="status-indicator available"></span>อภิชาติ สุขใจ (ว่าง)</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>เช็คลิสต์</label>
          <div class="checklist-builder">
            <div class="checklist-item">
              <input type="checkbox" id="check1" checked>
              <label for="check1">ตรวจสอบระดับน้ำมันเชื้อเพลิง</label>
            </div>
            <div class="checklist-item">
              <input type="checkbox" id="check2" checked>
              <label for="check2">ตรวจสอบสภาพยาง</label>
            </div>
            <div class="checklist-item">
              <input type="checkbox" id="check3" checked>
              <label for="check3">ตรวจสอบระบบไฟสัญญาณ</label>
            </div>
            <div class="checklist-item">
              <input type="checkbox" id="check4" checked>
              <label for="check4">ถ่ายรูปสภาพรถก่อนเริ่มงาน</label>
            </div>
            <div class="checklist-item">
              <input type="checkbox" id="check5" checked>
              <label for="check5">Roll Call ทุก 2 ชั่วโมง</label>
            </div>
            <div class="checklist-item">
              <input type="checkbox" id="check6" checked>
              <label for="check6">รายงานสภาพถนนและสภาพอากาศ</label>
            </div>

            <div class="add-item">
              <input type="text" placeholder="เพิ่มรายการตรวจสอบ...">
              <button type="button" class="btn btn-outline">เพิ่ม</button>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>ความสำคัญ</label>
          <div class="priority-options">
            <div class="priority-option priority-normal active">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                <path d="m9 12 2 2 4-4"></path>
              </svg>
              ปกติ
            </div>
            <div class="priority-option priority-urgent">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
              </svg>
              ด่วน
            </div>
            <div class="priority-option priority-emergency">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
              </svg>
              ฉุกเฉิน
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>กำหนดเวลาส่งงาน</label>
          <div class="datetime-group">
            <div class="form-group">
              <label for="start-date">วันที่เริ่มต้น</label>
              <input type="date" id="start-date">
            </div>
            <div class="form-group">
              <label for="start-time">เวลาเริ่มต้น</label>
              <input type="time" id="start-time">
            </div>
          </div>
          <div class="datetime-group" style="margin-top: 1rem;">
            <div class="form-group">
              <label for="end-date">วันที่สิ้นสุด</label>
              <input type="date" id="end-date">
            </div>
            <div class="form-group">
              <label for="end-time">เวลาสิ้นสุด (โดยประมาณ)</label>
              <input type="time" id="end-time">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="description">คำอธิบายงาน</label>
          <textarea id="description" rows="4" placeholder="ระบุรายละเอียดและคำแนะนำเพิ่มเติมสำหรับพนักงานขับรถ..."></textarea>
        </div>

        <div class="actions">
          <button type="button" class="btn btn-outline">ยกเลิก</button>
          <button type="submit" class="btn btn-primary submit-btn">สร้างงาน</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
