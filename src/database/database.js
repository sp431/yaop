const fs = require('fs');
const path = require('path');
const csv = require('csv-parser');
const fsExtra = require('fs-extra');

const dataPath = path.resolve(__dirname, 'medicines.json');

// 初始化数据文件
function initData() {
  if (!fs.existsSync(dataPath)) {
    fs.writeFileSync(dataPath, JSON.stringify([]));
    console.log('数据文件初始化成功');
  }
}

// 读取所有药品数据
function getAllMedicines() {
  initData();
  const data = fs.readFileSync(dataPath, 'utf8');
  return JSON.parse(data);
}

// 根据ID获取药品
function getMedicineById(id) {
  const medicines = getAllMedicines();
  return medicines.find(medicine => medicine.id == id);
}

// 添加药品
function addMedicine(medicine) {
  const medicines = getAllMedicines();
  const newId = medicines.length > 0 ? Math.max(...medicines.map(m => m.id)) + 1 : 1;
  const newMedicine = { id: newId, ...medicine };
  medicines.push(newMedicine);
  fs.writeFileSync(dataPath, JSON.stringify(medicines, null, 2));
  return newMedicine;
}

// 批量添加药品
function addMedicines(medicines) {
  const existingMedicines = getAllMedicines();
  let newId = existingMedicines.length > 0 ? Math.max(...existingMedicines.map(m => m.id)) + 1 : 1;
  
  const newMedicines = medicines.map(medicine => {
    const newMedicine = { id: newId++, ...medicine };
    existingMedicines.push(newMedicine);
    return newMedicine;
  });
  
  fs.writeFileSync(dataPath, JSON.stringify(existingMedicines, null, 2));
  return newMedicines;
}

// 更新药品
function updateMedicine(id, medicine) {
  const medicines = getAllMedicines();
  const index = medicines.findIndex(m => m.id == id);
  if (index !== -1) {
    medicines[index] = { id: parseInt(id), ...medicine };
    fs.writeFileSync(dataPath, JSON.stringify(medicines, null, 2));
    return true;
  }
  return false;
}

// 删除药品
function deleteMedicine(id) {
  const medicines = getAllMedicines();
  const filteredMedicines = medicines.filter(m => m.id != id);
  if (filteredMedicines.length !== medicines.length) {
    fs.writeFileSync(dataPath, JSON.stringify(filteredMedicines, null, 2));
    return true;
  }
  return false;
}

// 搜索药品
function searchMedicines(keyword) {
  const medicines = getAllMedicines();
  if (!keyword) return medicines;
  
  const lowerKeyword = keyword.toLowerCase();
  return medicines.filter(medicine => 
    (medicine.通用名称 || '').toLowerCase().includes(lowerKeyword) ||
    (medicine.商品名称 || '').toLowerCase().includes(lowerKeyword) ||
    (medicine.相关疾病 || '').toLowerCase().includes(lowerKeyword)
  );
}

// 导出为CSV
function exportToCSV(outputPath) {
  const medicines = getAllMedicines();
  
  // CSV头部
  const headers = [
    '通用名称', '商品名称', '汉语拼音', '相关疾病', '剂型', '主要成份', '适应症', 
    '规格', '不良反应', '用法用量', '禁忌', '注意事项', '儿童用药', '老人用药', 
    '药物相互作用', '药理毒理', '药代动力学', '贮藏', '有效期', '批准文号', 
    '生产企业', '药品分类', '药品性质', '备注'
  ];
  
  // 生成CSV内容
  let csvContent = headers.join(',') + '\n';
  
  medicines.forEach(medicine => {
    const row = headers.map(header => {
      const value = medicine[header] || '';
      // 处理包含逗号或换行符的值
      if (value.includes(',') || value.includes('\n') || value.includes('"')) {
        return '"' + value.replace(/"/g, '""') + '"';
      }
      return value;
    });
    csvContent += row.join(',') + '\n';
  });
  
  // 写入文件
  fs.writeFileSync(outputPath, csvContent, 'utf8');
  return true;
}

// 导入CSV
function importFromCSV(inputPath) {
  return new Promise((resolve, reject) => {
    const results = [];
    
    fs.createReadStream(inputPath)
      .pipe(csv())
      .on('data', (data) => results.push(data))
      .on('end', () => {
        try {
          const newMedicines = addMedicines(results);
          resolve(newMedicines);
        } catch (error) {
          reject(error);
        }
      })
      .on('error', (error) => {
        reject(error);
      });
  });
}

// 初始化
initData();

module.exports = {
  getAllMedicines,
  getMedicineById,
  addMedicine,
  addMedicines,
  updateMedicine,
  deleteMedicine,
  searchMedicines,
  exportToCSV,
  importFromCSV
};