<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<?= $this->include('partials/head') ?>

<!-- Required Remix Icon -->
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet" />

<body>

<section class="auth bg-base d-flex flex-wrap">
    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="<?= base_url('assets/images/auth/auth-img.png') ?>" alt="">
        </div>
    </div>

    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
        <div class="max-w-464-px mx-auto w-100">
            <div>
                <a href="<?= route_to('index') ?>" class="mb-40 max-w-290-px">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="">
                </a>
                <h4 class="mb-12">Sign In to your Account</h4>
                <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
            </div>

            <form action="<?= base_url('adminv4/authenticate'); ?>" method="POST">
                <!-- Email -->
                <div class="icon-field mb-16 position-relative">
                    <span class="icon position-absolute top-50 start-0 translate-middle-y ms-16">
                        <i class="ri-mail-line"></i>
                    </span>
                    <input id="email" name="email" type="email" class="form-control h-56-px bg-neutral-50 radius-12 ps-48" placeholder="Email">
                </div>

                <!-- Password -->
                <div class="position-relative mb-20">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-16">
                        <i class="ri-lock-line"></i>
                    </span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control h-56-px bg-neutral-50 radius-12 ps-48 pe-48"
                        placeholder="Password"
                    />
                    <span
                        class="position-absolute top-50 end-0 translate-middle-y me-16 cursor-pointer text-secondary-light"
                        id="togglePassword"
                    >
                        <i class="ri-eye-line" id="toggleIcon"></i>
                    </span>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</section>

<!-- JS Script -->
<script>
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    toggleIcon.addEventListener("click", function () {
        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";
        toggleIcon.classList.toggle("ri-eye-line");
        toggleIcon.classList.toggle("ri-eye-off-line");
    });
</script>

<?= $this->include('partials/scripts') ?> <!-- Global Scripts -->

</body>
</html>
