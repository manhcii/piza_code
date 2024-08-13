//Set time, hours cho form book now
const bookNowDate = document.querySelector('#booknowDate')
const bookNowHours = document.querySelector('#booknowHours')

const today = new Date();
const year = today.getFullYear();
const month = (today.getMonth() + 1).toString().padStart(2, '0')
const day = today.getDate().toString().padStart(2, '0')
const todayFormat = `${year}-${month}-${day}`
bookNowDate.setAttribute('min', todayFormat)
bookNowDate.value = todayFormat

const currentHour = today.getHours().toString().padStart(2, '0');
const currentMinute = today.getMinutes().toString().padStart(2, '0');
const currentTimeString = `${currentHour}:${currentMinute}`;

bookNowHours.setAttribute("min", currentTimeString);
bookNowHours.value = currentTimeString