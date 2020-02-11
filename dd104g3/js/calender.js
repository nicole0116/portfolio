function calender(selector) {
  const date = new Date();
  const allMonth = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec"
  ];
  let contorl = [...selector.childNodes].find(
    node => node.className === "calendar_header"
  );
  let prev = [...contorl.childNodes].filter(
    childNode => childNode.className === "prev"
  )[0];
  let next = [...contorl.childNodes].filter(
    childNode => childNode.className === "next"
  )[0];
  let month = [...contorl.childNodes].find(
    childNode => childNode.className === "month"
  );
  let calendar = [...selector.childNodes].find(
    node => node.className === "calendar_body"
  );
  const allWeek = ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"];

  prev.addEventListener("click", () => {
    changeMonth(nowMonth - 1);
  });
  next.addEventListener("click", () => {
    changeMonth(nowMonth + 1);
  });

  function changeMonth(index) {
    let direction = nowMonth - index;
    if (direction < 0) {
      nowMonth === 11 ? (nowYear += 1) : nowYear;
    } else {
      nowMonth === 0 ? (nowYear -= 1) : nowYear;
    }
    nowMonth = (index + 12) % 12;
    resetDate();
  }

  function isLeap(nowYear) {
    if ((!(nowYear % 4) && nowYear % 100) || !(nowYear % 400)) {
      return 29;
    } else {
      return 28;
    }
  }

  let fullDate, day;
  let nowYear = date.getFullYear();
  let nowMonth = date.getMonth();
  let nowDate = date.getDate();

  function getDate() {
    let firstDay = new Date(`${allMonth[nowMonth]} ${1} ${nowYear}`).getDay();

    if (nowMonth < 7) {
      nowMonth % 2 ? (fullDate = 30) : (fullDate = 31);
    } else {
      nowMonth % 2 ? (fullDate = 31) : (fullDate = 30);
    }
    if (nowMonth === 1) fullDate = isLeap(nowYear);
    month.innerText = `${allMonth[nowMonth]} ${nowYear}`;

    day = 1;
    createDay(day, firstDay, true);
  }

  function createDay(days, firstDay = 0, isFirstWeek = false) {
    let tr = document.createElement("tr");
    for (let i = 0; i < 7; i++) {
      let td = document.createElement("td");
      let week = document.createElement("p");
      let day = document.createElement("p");
      if (i >= firstDay && days <= fullDate) {
        day.innerText = days;
        if (
          nowDate === days &&
          nowMonth === date.getMonth() &&
          nowYear === date.getFullYear()
        ) {
          td.classList.add("now");
        }
        days++;
      }
      if (isFirstWeek) week.innerText = allWeek[i];
      td.appendChild(week);
      td.appendChild(day);
      tr.appendChild(td);
    }
    calendar.appendChild(tr);
    if (days <= fullDate) createDay(days);
  }

  function resetDate() {
    while (calendar.hasChildNodes()) {
      calendar.removeChild(calendar.lastChild);
    }
    getDate();
  }

  getDate();
}
