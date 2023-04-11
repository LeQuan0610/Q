package com.example.registrationlogindemo.checkpass;

import jakarta.validation.ConstraintValidator;
import jakarta.validation.ConstraintValidatorContext;
import com.google.common.base.Joiner;
import org.passay.*;

import java.util.Arrays;

public class PasswordConstraintValidator implements ConstraintValidator<ValidPassword, String> {

    @Override
    public void initialize(ValidPassword arg0) {
    }

    @Override
    public boolean isValid(String password, ConstraintValidatorContext context) {
        PasswordValidator validator = new PasswordValidator(Arrays.asList(
                new LengthRule(8, 30),                            // Quy tắc kiểm tra độ dài mật khẩu, trong đó mật khẩu phải có ít nhất 8 ký tự và tối đa là 30 ký tự.
                new UppercaseCharacterRule(1),              // Quy tắc kiểm tra mật khẩu có ít nhất một ký tự in hoa hay không.
                new DigitCharacterRule(1),                  // Quy tắc kiểm tra mật khẩu có ít nhất một chữ số hay không.
//                new SpecialCharacterRule(1),                // Quy tắc kiểm tra mật khẩu có ít nhất một ký tự đặc biệt hay không.
//                new NumericalSequenceRule(3,false), // Quy tắc kiểm tra mật khẩu có chứa chuỗi số liên tiếp (số nguyên tố) có ít nhất 3 số hay không.
//                new AlphabeticalSequenceRule(3,false),  // Quy tắc kiểm tra mật khẩu có chứa chuỗi ký tự liên tiếp theo thứ tự bảng chữ cái có ít nhất 3 ký tự hay không.
//                new QwertySequenceRule(3,false),        // Quy tắc kiểm tra mật khẩu có chứa chuỗi ký tự liên tiếp trên bàn phím Qwerty có ít nhất 3 ký tự hay không.
                new WhitespaceRule()));                           // Quy tắc kiểm tra mật khẩu có chứa khoảng trắng hay không.

        RuleResult result = validator.validate(new PasswordData(password));
        if (result.isValid()) {
            return true;
        }
        context.disableDefaultConstraintViolation();
        context.buildConstraintViolationWithTemplate(
                        Joiner.on(",").join(validator.getMessages(result)))
                .addConstraintViolation();
        return false;
    }
}
