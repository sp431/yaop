const express = require('express');
const path = require('path');
const fs = require('fs');
const multer = require('multer');
const db = require('./database/database');

const app = express();
const port = 3000;

// 设置视图引擎
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// 中间件
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));

// 用于处理文件上传的临时存储
const uploadDir = path.join(__dirname, 'uploads');
if (!fs.existsSync(uploadDir)) {
  fs.mkdirSync(uploadDir);
}

// 配置multer
const storage = multer.diskStorage({
  destination: function (req, file, cb) {
    cb(null, uploadDir);
  },
  filename: function (req, file, cb) {
    cb(null, Date.now() + '-' + file.originalname);
  }
});

// 文件过滤，只允许CSV文件
const fileFilter = function (req, file, cb) {
  if (file.mimetype === 'text/csv' || file.originalname.endsWith('.csv')) {
    cb(null, true);
  } else {
    cb(new Error('只允许上传CSV文件'), false);
  }
};

const upload = multer({ storage: storage, fileFilter: fileFilter });

// 路由
app.get('/', (req, res) => {
  res.redirect('/medicines');
});

// 导出CSV
app.get('/medicines/export', (req, res) => {
  try {
    const outputPath = path.join(__dirname, 'uploads', `medicines_${Date.now()}.csv`);
    db.exportToCSV(outputPath);
    
    res.download(outputPath, 'medicines.csv', (err) => {
      if (err) {
        console.error(err.message);
        res.status(500).send('导出失败');
      } else {
        // 下载完成后删除临时文件
        fs.unlinkSync(outputPath);
      }
    });
  } catch (err) {
    console.error(err.message);
    res.status(500).send('导出失败');
  }
});

// 导入CSV页面
app.get('/medicines/import', (req, res) => {
  res.render('import');
});

// 处理CSV上传
app.post('/medicines/import', upload.single('csvFile'), async (req, res) => {
  try {
    if (!req.file) {
      return res.status(400).send('请选择要上传的CSV文件');
    }
    
    const filePath = req.file.path;
    await db.importFromCSV(filePath);
    
    // 导入完成后删除临时文件
    fs.unlinkSync(filePath);
    
    res.redirect('/medicines?message=导入成功');
  } catch (err) {
    console.error(err.message);
    // 清理临时文件
    if (req.file && fs.existsSync(req.file.path)) {
      fs.unlinkSync(req.file.path);
    }
    res.status(500).send('导入失败: ' + err.message);
  }
});

// 药品列表页面
app.get('/medicines', (req, res) => {
  const search = req.query.search || '';
  let medicines = [];
  
  try {
    if (search) {
      medicines = db.searchMedicines(search);
    } else {
      medicines = db.getAllMedicines();
    }
    res.render('index', { medicines, search, req });
  } catch (err) {
    console.error(err.message);
    res.status(500).send('服务器错误');
  }
});

// 药品添加页面
app.get('/medicines/add', (req, res) => {
  res.render('add');
});

// 药品添加处理
app.post('/medicines/add', (req, res) => {
  const { 通用名称, 商品名称, 汉语拼音, 相关疾病, 剂型, 主要成份, 适应症, 规格, 不良反应, 用法用量, 禁忌, 注意事项, 儿童用药, 老人用药, 药物相互作用, 药理毒理, 药代动力学, 贮藏, 有效期, 批准文号, 生产企业, 药品分类, 药品性质, 备注 } = req.body;
  
  try {
    db.addMedicine({
      通用名称,
      商品名称,
      汉语拼音,
      相关疾病,
      剂型,
      主要成份,
      适应症,
      规格,
      不良反应,
      用法用量,
      禁忌,
      注意事项,
      儿童用药,
      老人用药,
      药物相互作用,
      药理毒理,
      药代动力学,
      贮藏,
      有效期,
      批准文号,
      生产企业,
      药品分类,
      药品性质,
      备注
    });
    res.redirect('/medicines');
  } catch (err) {
    console.error(err.message);
    res.status(500).send('服务器错误');
  }
});

// 药品详情页面
app.get('/medicines/:id', (req, res) => {
  const id = req.params.id;
  
  try {
    const medicine = db.getMedicineById(id);
    
    if (!medicine) {
      res.status(404).send('药品不存在');
    } else {
      res.render('detail', { medicine });
    }
  } catch (err) {
    console.error(err.message);
    res.status(500).send('服务器错误');
  }
});

// 药品修改页面
app.get('/medicines/:id/edit', (req, res) => {
  const id = req.params.id;
  
  try {
    const medicine = db.getMedicineById(id);
    
    if (!medicine) {
      res.status(404).send('药品不存在');
    } else {
      res.render('edit', { medicine });
    }
  } catch (err) {
    console.error(err.message);
    res.status(500).send('服务器错误');
  }
});

// 药品修改处理
app.post('/medicines/:id/edit', (req, res) => {
  const id = req.params.id;
  const { 通用名称, 商品名称, 汉语拼音, 相关疾病, 剂型, 主要成份, 适应症, 规格, 不良反应, 用法用量, 禁忌, 注意事项, 儿童用药, 老人用药, 药物相互作用, 药理毒理, 药代动力学, 贮藏, 有效期, 批准文号, 生产企业, 药品分类, 药品性质, 备注 } = req.body;
  
  try {
    const success = db.updateMedicine(id, {
      通用名称,
      商品名称,
      汉语拼音,
      相关疾病,
      剂型,
      主要成份,
      适应症,
      规格,
      不良反应,
      用法用量,
      禁忌,
      注意事项,
      儿童用药,
      老人用药,
      药物相互作用,
      药理毒理,
      药代动力学,
      贮藏,
      有效期,
      批准文号,
      生产企业,
      药品分类,
      药品性质,
      备注
    });
    
    if (success) {
      res.redirect('/medicines');
    } else {
      res.status(404).send('药品不存在');
    }
  } catch (err) {
    console.error(err.message);
    res.status(500).send('服务器错误');
  }
});

// 药品删除处理
app.post('/medicines/:id/delete', (req, res) => {
  const id = req.params.id;
  
  try {
    const success = db.deleteMedicine(id);
    
    if (success) {
      res.redirect('/medicines');
    } else {
      res.status(404).send('药品不存在');
    }
  } catch (err) {
    console.error(err.message);
    res.status(500).send('服务器错误');
  }
});

// 启动服务器
app.listen(port, () => {
  console.log(`服务器运行在 http://localhost:${port}`);
});