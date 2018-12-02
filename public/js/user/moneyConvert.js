function money(price)
{
    var result = [];
    var length = price.length;
    var tmpPrice = price;
    while (length - 3 > 0) {
        result.push(tmpPrice.substr(length - 4, 3));
        tmpPrice = tmpPrice.substr(0, length - 3);
        length -= 3;
    }
    result.push(tmpPrice);
    result = result.slice().reverse();
    return result.join('.');
}
