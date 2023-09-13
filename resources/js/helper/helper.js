const ListRibaldry = [
    "cặt", "đụ", "đụ mạ", "địt mẹ", "fuck", 'dann', 'lồn', "địt", 'địt bố', 'cặc', 'đồ chó', 'đồ cún', 'đồ con chó',
    'shit', 'shjt', 'fucked', 'địtme', 'địtma', 'đù má', 'đị mẹ'
];
function checkRibaldry(content) {
    console.log(content);
    if (content) {
        let textContent = content.toLowerCase();
        return ListRibaldry.some((char) => textContent.includes(char.toLowerCase()));
    }
    return false
}


// Sử dụng hàm kiểm tra
// const chuoiCanKiemTra = "Chuỗi chứa từ1 và từ2"; // Thay đổi chuỗi này theo nhu cầu
// const coTuNgoiTuc = checkRibaldry(chuoiCanKiemTra);

// if (coTuNgoiTuc) {
//     console.log("Chuỗi chứa từ nói tục.");
// } else {
//     console.log("Chuỗi không chứa từ nói tục.");
// }
export default{
    checkRibaldry
}