export function splitFutureAndPast(items) {
  var split_list = [[],[]];
  for (var item of items){
    var y_m_d = item.date.split('-', 3);
    var today = new Date(Date.now());
    var target = new Date(Number(y_m_d[0]), Number(y_m_d[1]) - 1, Number(y_m_d[2])
      , 0, 0, 0, 0);
    if (today < target) {
      split_list[0].push({'date': item.date, 'body': item.body});
    }else{
      split_list[1].push({'date': item.date, 'body': item.body});
    }
  }
  return split_list;
}