<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);
?>

<div class="content">
    <div class="floatwrap">
        <!-- 회원가입약관 동의 시작 { -->
        <div class="register">
            <div class="step">
                <ul>
                    <li class="active">01.약관동의</li>
                    <li>02.정보입력</li>
                    <li>03.가입완료</li>
                </ul>
            </div>
            <?php
            // 소셜로그인 사용시 소셜로그인 버튼
            @include_once(get_social_skin_path() . '/social_register.skin.php');
            ?>

            <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
                <section id="fregister_term" class="desc">
                    <div class="head">
                        <h2><i class="fa fa-check-square-o" aria-hidden="true"></i> 회원가입약관</h2>
                        <fieldset class="fregister_agree">
                            <input type="checkbox" name="agree" value="1" id="agree11" class="tgl tgl-ios">
                            <label class="tgl-btn" for="agree11"></label>
                            <span>회원가입약관의 내용에 동의합니다.</span>
                        </fieldset>
                    </div>
                    <div class="body">
                        <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
                    </div>
                </section>

                <section id="fregister_private" class="desc">
                    <div class="head">
                        <h2><i class="fa fa-check-square-o" aria-hidden="true"></i> 개인정보처리방침안내</h2>
                        <fieldset class="fregister_agree">
                            <input type="checkbox" name="agree2" value="1" id="agree21" class="tgl tgl-ios">
                            <label class="tgl-btn" for="agree21"></label>
                            <span>개인정보처리방침안내의 내용에 동의합니다.</span>
                        </fieldset>
                    </div>
                    <div class="body">
                        <table>
                            <caption>개인정보처리방침안내</caption>
                            <thead>
                                <tr>
                                    <th>목적</th>
                                    <th>항목</th>
                                    <th>보유기간</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>이용자 식별 및 본인여부 확인</td>
                                    <td>아이디, 이름, 비밀번호</td>
                                    <td>회원 탈퇴 시까지</td>
                                </tr>
                                <tr>
                                    <td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
                                    <td>연락처 (이메일, 휴대전화번호)</td>
                                    <td>회원 탈퇴 시까지</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <div id="fregister_chkall" class="chk_all fregister_all">
                    <p>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.<br>회원가입시 제공하신 개인정보(주소 성함 연락처  이메일)는 푸드홀릭에서 이벤트 문자발송 및 배송용으로만 활용합니다.</p>
                    <div class="chk_wrap">
                        <input type="checkbox" name="chk_all" value="1" id="chk_all" class="tgl tgl-ios">
                        <label class="tgl-btn" for="chk_all"></label>
                        <span>회원가입 약관에 모두 동의합니다.</span>
                    </div>

                </div>
                <div class="btn_confirm">
                    <a href="<?php echo G5_URL ?>" class="btn_close">취소</a>
                    <input type="submit" class="btn_submit" value="회원가입">
                </div>
            </form>

            <script>
                function fregister_submit(f) {
                    if (!f.agree.checked) {
                        alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
                        f.agree.focus();
                        return false;
                    }

                    if (!f.agree2.checked) {
                        alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
                        f.agree2.focus();
                        return false;
                    }

                    return true;
                }

                jQuery(function($) {
                    // 모두선택
                    $("input[name=chk_all]").click(function() {
                        if ($(this).prop('checked')) {
                            $("input[name^=agree]").prop('checked', true);
                        } else {
                            $("input[name^=agree]").prop("checked", false);
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
<!-- } 회원가입 약관 동의 끝 -->