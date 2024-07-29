export function dateTimeYMDtoDMY(YMDdate) {
  const date_arr = YMDdate.split(" ");
  const date_aar2 = date_arr[0].split("-");
  const new_date = date_aar2[2] + "-" + date_aar2[1] + "-" + date_aar2[0] + " " + date_arr[1];
  return new_date;
}

export function dateTimeISO8601toDMY(ISO8601date) {
  const dateStr = ISO8601date, [yyyy,mm,dd,hh,mi] = dateStr.split(/[/:\-T]/);
  return `${dd}-${mm}-${yyyy} ${hh}:${mi}`;
}