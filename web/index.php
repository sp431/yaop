<?php
// 数据库连接配置
$dbFile = 'medicines.db';

// 初始化数据库
function initDatabase() {
    global $dbFile;
    $db = new SQLite3($dbFile);
    
    // 创建药品表
    $sql = "
        CREATE TABLE IF NOT EXISTS medicines (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            通用名称 TEXT,
            商品名称 TEXT,
            汉语拼音 TEXT,
            相关疾病 TEXT,
            剂型 TEXT,
            主要成份 TEXT,
            适应症 TEXT,
            规格 TEXT,
            不良反应 TEXT,
            用法用量 TEXT,
            禁忌 TEXT,
            注意事项 TEXT,
            儿童用药 TEXT,
            老人用药 TEXT,
            药物相互作用 TEXT,
            药理毒理 TEXT,
            药代动力学 TEXT,
            贮藏 TEXT,
            有效期 TEXT,
            批准文号 TEXT,
            生产企业 TEXT,
            药品分类 TEXT,
            药品性质 TEXT,
            备注 TEXT
        );
    ";
    
    $db->exec($sql);
    $db->close();
}

// 初始化数据库
initDatabase();

// 处理不同的请求
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 处理添加药品
            addMedicine();
        } else {
            // 显示添加表单
            showAddForm();
        }
        break;
    case 'detail':
        $id = $_GET['id'] ?? 0;
        showDetail($id);
        break;
    case 'edit':
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 处理修改药品
            updateMedicine($id);
        } else {
            // 显示修改表单
            showEditForm($id);
        }
        break;
    case 'delete':
        $id = $_GET['id'] ?? 0;
        deleteMedicine($id);
        break;
    case 'import':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 处理导入
            importCSV();
        } else {
            // 显示导入表单
            showImportForm();
        }
        break;
    case 'export':
        exportCSV();
        break;
    default:
        // 显示药品列表
        showList();
        break;
}

// 显示药品列表
function showList() {
    $search = $_GET['search'] ?? '';
    $message = $_GET['message'] ?? '';
    
    $db = new SQLite3('medicines.db');
    
    if (!empty($search)) {
        $stmt = $db->prepare('SELECT * FROM medicines WHERE 通用名称 LIKE ? OR 商品名称 LIKE ? OR 相关疾病 LIKE ?');
        $searchParam = '%' . $search . '%';
        $stmt->bindValue(1, $searchParam, SQLITE3_TEXT);
        $stmt->bindValue(2, $searchParam, SQLITE3_TEXT);
        $stmt->bindValue(3, $searchParam, SQLITE3_TEXT);
        $result = $stmt->execute();
    } else {
        $result = $db->query('SELECT * FROM medicines');
    }
    
    $medicines = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $medicines[] = $row;
    }
    
    $db->close();
    
    include 'templates/list.php';
}

// 显示添加表单
function showAddForm() {
    include 'templates/add.php';
}

// 添加药品
function addMedicine() {
    $data = $_POST;
    
    $db = new SQLite3('medicines.db');
    $stmt = $db->prepare("
        INSERT INTO medicines (
            通用名称, 商品名称, 汉语拼音, 相关疾病, 剂型, 主要成份, 适应症, 
            规格, 不良反应, 用法用量, 禁忌, 注意事项, 儿童用药, 老人用药, 
            药物相互作用, 药理毒理, 药代动力学, 贮藏, 有效期, 批准文号, 
            生产企业, 药品分类, 药品性质, 备注
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ");
    
    $stmt->bindValue(1, $data['通用名称'], SQLITE3_TEXT);
    $stmt->bindValue(2, $data['商品名称'], SQLITE3_TEXT);
    $stmt->bindValue(3, $data['汉语拼音'], SQLITE3_TEXT);
    $stmt->bindValue(4, $data['相关疾病'], SQLITE3_TEXT);
    $stmt->bindValue(5, $data['剂型'], SQLITE3_TEXT);
    $stmt->bindValue(6, $data['主要成份'], SQLITE3_TEXT);
    $stmt->bindValue(7, $data['适应症'], SQLITE3_TEXT);
    $stmt->bindValue(8, $data['规格'], SQLITE3_TEXT);
    $stmt->bindValue(9, $data['不良反应'], SQLITE3_TEXT);
    $stmt->bindValue(10, $data['用法用量'], SQLITE3_TEXT);
    $stmt->bindValue(11, $data['禁忌'], SQLITE3_TEXT);
    $stmt->bindValue(12, $data['注意事项'], SQLITE3_TEXT);
    $stmt->bindValue(13, $data['儿童用药'], SQLITE3_TEXT);
    $stmt->bindValue(14, $data['老人用药'], SQLITE3_TEXT);
    $stmt->bindValue(15, $data['药物相互作用'], SQLITE3_TEXT);
    $stmt->bindValue(16, $data['药理毒理'], SQLITE3_TEXT);
    $stmt->bindValue(17, $data['药代动力学'], SQLITE3_TEXT);
    $stmt->bindValue(18, $data['贮藏'], SQLITE3_TEXT);
    $stmt->bindValue(19, $data['有效期'], SQLITE3_TEXT);
    $stmt->bindValue(20, $data['批准文号'], SQLITE3_TEXT);
    $stmt->bindValue(21, $data['生产企业'], SQLITE3_TEXT);
    $stmt->bindValue(22, $data['药品分类'], SQLITE3_TEXT);
    $stmt->bindValue(23, $data['药品性质'], SQLITE3_TEXT);
    $stmt->bindValue(24, $data['备注'], SQLITE3_TEXT);
    
    $stmt->execute();
    $db->close();
    
    header('Location: index.php?message=添加成功');
}

// 显示详情
function showDetail($id) {
    $db = new SQLite3('medicines.db');
    $stmt = $db->prepare('SELECT * FROM medicines WHERE id = ?');
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $medicine = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
    
    if (!$medicine) {
        header('Location: index.php?message=药品不存在');
        exit;
    }
    
    include 'templates/detail.php';
}

// 显示修改表单
function showEditForm($id) {
    $db = new SQLite3('medicines.db');
    $stmt = $db->prepare('SELECT * FROM medicines WHERE id = ?');
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $medicine = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
    
    if (!$medicine) {
        header('Location: index.php?message=药品不存在');
        exit;
    }
    
    include 'templates/edit.php';
}

// 更新药品
function updateMedicine($id) {
    $data = $_POST;
    
    $db = new SQLite3('medicines.db');
    $stmt = $db->prepare("
        UPDATE medicines SET
            通用名称 = ?,
            商品名称 = ?,
            汉语拼音 = ?,
            相关疾病 = ?,
            剂型 = ?,
            主要成份 = ?,
            适应症 = ?,
            规格 = ?,
            不良反应 = ?,
            用法用量 = ?,
            禁忌 = ?,
            注意事项 = ?,
            儿童用药 = ?,
            老人用药 = ?,
            药物相互作用 = ?,
            药理毒理 = ?,
            药代动力学 = ?,
            贮藏 = ?,
            有效期 = ?,
            批准文号 = ?,
            生产企业 = ?,
            药品分类 = ?,
            药品性质 = ?,
            备注 = ?
        WHERE id = ?
    ");
    
    $stmt->bindValue(1, $data['通用名称'], SQLITE3_TEXT);
    $stmt->bindValue(2, $data['商品名称'], SQLITE3_TEXT);
    $stmt->bindValue(3, $data['汉语拼音'], SQLITE3_TEXT);
    $stmt->bindValue(4, $data['相关疾病'], SQLITE3_TEXT);
    $stmt->bindValue(5, $data['剂型'], SQLITE3_TEXT);
    $stmt->bindValue(6, $data['主要成份'], SQLITE3_TEXT);
    $stmt->bindValue(7, $data['适应症'], SQLITE3_TEXT);
    $stmt->bindValue(8, $data['规格'], SQLITE3_TEXT);
    $stmt->bindValue(9, $data['不良反应'], SQLITE3_TEXT);
    $stmt->bindValue(10, $data['用法用量'], SQLITE3_TEXT);
    $stmt->bindValue(11, $data['禁忌'], SQLITE3_TEXT);
    $stmt->bindValue(12, $data['注意事项'], SQLITE3_TEXT);
    $stmt->bindValue(13, $data['儿童用药'], SQLITE3_TEXT);
    $stmt->bindValue(14, $data['老人用药'], SQLITE3_TEXT);
    $stmt->bindValue(15, $data['药物相互作用'], SQLITE3_TEXT);
    $stmt->bindValue(16, $data['药理毒理'], SQLITE3_TEXT);
    $stmt->bindValue(17, $data['药代动力学'], SQLITE3_TEXT);
    $stmt->bindValue(18, $data['贮藏'], SQLITE3_TEXT);
    $stmt->bindValue(19, $data['有效期'], SQLITE3_TEXT);
    $stmt->bindValue(20, $data['批准文号'], SQLITE3_TEXT);
    $stmt->bindValue(21, $data['生产企业'], SQLITE3_TEXT);
    $stmt->bindValue(22, $data['药品分类'], SQLITE3_TEXT);
    $stmt->bindValue(23, $data['药品性质'], SQLITE3_TEXT);
    $stmt->bindValue(24, $data['备注'], SQLITE3_TEXT);
    $stmt->bindValue(25, $id, SQLITE3_INTEGER);
    
    $stmt->execute();
    $db->close();
    
    header('Location: index.php?message=修改成功');
}

// 删除药品
function deleteMedicine($id) {
    $db = new SQLite3('medicines.db');
    $stmt = $db->prepare('DELETE FROM medicines WHERE id = ?');
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();
    
    header('Location: index.php?message=删除成功');
}

// 显示导入表单
function showImportForm() {
    include 'templates/import.php';
}

// 导入CSV
function importCSV() {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csvFile']['tmp_name'];
        $fileName = $_FILES['csvFile']['name'];
        $fileSize = $_FILES['csvFile']['size'];
        $fileType = $_FILES['csvFile']['type'];
        
        // 检查文件类型
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($fileExt !== 'csv') {
            header('Location: index.php?action=import&message=只允许上传CSV文件');
            exit;
        }
        
        // 读取CSV文件
        $file = fopen($fileTmpPath, 'r');
        if ($file) {
            // 读取表头
            $headers = fgetcsv($file);
            
            $db = new SQLite3('medicines.db');
            
            while (($data = fgetcsv($file)) !== false) {
                if (count($data) >= 24) {
                    $stmt = $db->prepare("
                        INSERT INTO medicines (
                            通用名称, 商品名称, 汉语拼音, 相关疾病, 剂型, 主要成份, 适应症, 
                            规格, 不良反应, 用法用量, 禁忌, 注意事项, 儿童用药, 老人用药, 
                            药物相互作用, 药理毒理, 药代动力学, 贮藏, 有效期, 批准文号, 
                            生产企业, 药品分类, 药品性质, 备注
                        ) VALUES (
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )
                    ");
                    
                    for ($i = 0; $i < 24; $i++) {
                        $stmt->bindValue($i + 1, $data[$i] ?? '', SQLITE3_TEXT);
                    }
                    
                    $stmt->execute();
                }
            }
            
            fclose($file);
            $db->close();
            
            header('Location: index.php?message=导入成功');
            exit;
        }
    }
    
    header('Location: index.php?action=import&message=导入失败');
}

// 导出CSV
function exportCSV() {
    $db = new SQLite3('medicines.db');
    $result = $db->query('SELECT * FROM medicines');
    
    // 设置响应头
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=medicines.csv');
    
    // 打开输出流
    $output = fopen('php://output', 'w');
    
    // 写入表头
    $headers = [
        '通用名称', '商品名称', '汉语拼音', '相关疾病', '剂型', '主要成份', '适应症', 
        '规格', '不良反应', '用法用量', '禁忌', '注意事项', '儿童用药', '老人用药', 
        '药物相互作用', '药理毒理', '药代动力学', '贮藏', '有效期', '批准文号', 
        '生产企业', '药品分类', '药品性质', '备注'
    ];
    fputcsv($output, $headers);
    
    // 写入数据
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $data = [
            $row['通用名称'], $row['商品名称'], $row['汉语拼音'], $row['相关疾病'], 
            $row['剂型'], $row['主要成份'], $row['适应症'], $row['规格'], 
            $row['不良反应'], $row['用法用量'], $row['禁忌'], $row['注意事项'], 
            $row['儿童用药'], $row['老人用药'], $row['药物相互作用'], $row['药理毒理'], 
            $row['药代动力学'], $row['贮藏'], $row['有效期'], $row['批准文号'], 
            $row['生产企业'], $row['药品分类'], $row['药品性质'], $row['备注']
        ];
        fputcsv($output, $data);
    }
    
    fclose($output);
    $db->close();
    exit;
}
?>