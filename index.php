<?php 
include './inc/db.php';
include './inc/form.php';
include './inc/select.php';
include './inc/db_close.php';
?>

<?php include_once './inc/parts/header.php'; ?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
   <img src="images/ooomar.jpg" alt="">
   <h1 class="display-4 fw-normal">اربح مع عمر</h1>
   <p class="lead fw-normal">باقي على فتح التسجيل</p>
   <h3 id="countdown"></h3>
   <p class="lead fw-normal">للسحب على ربح نسخه مجانيه من برنامج</p>
</div>

<h3>  للدخول في السحب اتبع ما يلي: </h3>
<ul class="list-group list-group-flush">
    <li class="list-group-item">تابع حسابي على الفيسبوك بالتاريخ المذكور أعلاه</li>
    <li class="list-group-item">سأقوم ببث مباشر لمدة ساعة عبارة عن أسئلة وأجوبة حرة للجميع</li>
    <li class="list-group-item">سيتم فتح صفحة التسجيل هنا حيث تقوم بتسجيل اسمك وإيميلك</li>
    <li class="list-group-item">السحب سيكون بشكل عشوائي من قاعدة البيانات</li>
    <li class="list-group-item">الرابح سيحصل على نسخة مجانية من برنامج كامتازيا</li>
</ul>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <form class="mt-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h3>الرجاء ادخل معلوماتك</h3>
            <div class="mb-3">
                <label for="firstName" class="form-label">الاسم الأول</label>
                <input type="text" name="firstName" class="form-control" id="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
                <div class="form-text error"><?php echo htmlspecialchars($errors['firstNameError']); ?></div>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">الاسم الأخير</label>
                <input type="text" name="lastName" class="form-control" id="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
                <div class="form-text error"><?php echo htmlspecialchars($errors['lastNameError']); ?></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>">
                <div class="form-text error"><?php echo htmlspecialchars($errors['emailError']); ?></div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<div class="loader-con" style="display:none;">
    <div id="loader">
        <canvas id="circularLoader" width="200" height="200"></canvas>
    </div>
</div>

<!-- Button trigger modal -->
<div class="d-grid gap-2 col-6 mx-auto my-5"> 
    <button type="button" id="winner" class="btn btn-primary">اختيار الرابح</button>
</div>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">الرابح في المسابقة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1 class="display-3 text-center" id="winnerName"></h1>
            </div>
        </div>
    </div>
</div>

<?php include_once './inc/parts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
<script>
var countDownDate = new Date("Dec 5, 2024 15:37:25").getTime();

var x = setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;

    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("countdown").innerHTML = days + " يوم " + hours + " ساعة " + minutes + " دقيقة " + seconds + " ثانية ";

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "لقد وصلت متأخراً";
    }
}, 1000);

const win = document.querySelector("#winner");
const loader = document.querySelector(".loader-con");
const myModal = new bootstrap.Modal(document.getElementById('Modal'), { keyboard: false });
const winnerName = document.getElementById('winnerName');

win.addEventListener('click', function() {
    loader.style.display = 'block';
    sim = setInterval(progressSim, 20);
});

var ctx = document.getElementById('circularLoader').getContext('2d');
var al = 0;
var start = 4.72;
var cw = ctx.canvas.width;
var ch = ctx.canvas.height; 
var diff;
var sim;
function progressSim() {
    diff = ((al / 100) * Math.PI * 2 * 10).toFixed(2);
    ctx.clearRect(0, 0, cw, ch);
    ctx.lineWidth = 17;
    ctx.fillStyle = '#370bd7';
    ctx.strokeStyle = "#370bd7";
    ctx.textAlign = "center";
    ctx.font = "28px monospace";
    ctx.fillText(al + '%', cw * 0.52, ch * 0.5 + 5, cw + 12);
    ctx.beginPath();
    ctx.arc(100, 100, 75, start, diff / 10 + start, false);
    ctx.stroke();
    if (al >= 100) {
        clearTimeout(sim);
        const users = <?php echo json_encode($users); ?>;
        const randomIndex = Math.floor(Math.random() * users.length);
        const winner = users[randomIndex];

        winnerName.textContent = `${winner.firstName} ${winner.lastName}`;
        myModal.show();
        loader.style.display = 'none';
        confetti();
    }
    al++;
}
</script>
