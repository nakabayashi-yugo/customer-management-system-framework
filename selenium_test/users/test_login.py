from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

chrome_driver_path = r"C:\Users\nakabayashi-yugo\tools\chromedriver-win64\chromedriver.exe"

def test_login_success():
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)

    try:
        driver.get("http://localhost:3000/user_login")

        driver.find_element(By.NAME, "user-name").send_keys("nakabayashi")
        driver.find_element(By.NAME, "password").send_keys("nakabayashi2025")
        driver.find_element(By.XPATH, "//button[text()='ログイン']").click()

        # ✅ アラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())

        # ✅ アラート処理
        alert = driver.switch_to.alert
        print("アラート内容:", alert.text)
        alert.accept()

        time.sleep(1)

        # 成功後の画面の文言確認（必要に応じて変更）
        assert "顧客管理システム" in driver.page_source

    finally:
        driver.quit()

def test_login_fail_with_not_username():
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)

    try:
        driver.get("http://localhost:3000/user_login")

        driver.find_element(By.NAME, "user-name").send_keys("nakaba")
        driver.find_element(By.NAME, "password").send_keys("nakabayashi2025")
        driver.find_element(By.XPATH, "//button[text()='ログイン']").click()

        # ✅ アラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())

        # ✅ アラート処理
        alert = driver.switch_to.alert
        print("アラート内容:", alert.text)
        alert.accept()

        time.sleep(1)

        # 成功後の画面の文言確認（必要に応じて変更）
        assert "ログイン" in driver.page_source

    finally:
        driver.quit()

def test_login_fail_with_mismatch_password():
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)

    try:
        driver.get("http://localhost:3000/user_login")

        driver.find_element(By.NAME, "user-name").send_keys("nakabayashi")
        driver.find_element(By.NAME, "password").send_keys("nakaba")
        driver.find_element(By.XPATH, "//button[text()='ログイン']").click()

        # ✅ アラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())

        # ✅ アラート処理
        alert = driver.switch_to.alert
        print("アラート内容:", alert.text)
        alert.accept()

        time.sleep(1)

        # 成功後の画面の文言確認（必要に応じて変更）
        assert "ログイン" in driver.page_source

    finally:
        driver.quit()


if __name__ == "__main__":
    test_login_success()
    test_login_fail_with_not_username()
    test_login_fail_with_mismatch_password()
