const ListRibaldry = [
    "cặt", "đụ", "đụ mạ", "địt mẹ", "fuck", 'dann', 'lồn', "địt", 'địt bố', 'cặc', 'đồ chó', 'đồ cún', 'đồ con chó',
    'shit', 'shjt', 'fucked', 'địtme', 'địtma', 'đù má', 'đị mẹ'
];
function checkRibaldry(content) {
    if (content) {
        let textContent = content.toLowerCase();
        return ListRibaldry.some((char) => textContent.includes(char.toLowerCase()));
    }
    return false
}
export default{
    checkRibaldry
}