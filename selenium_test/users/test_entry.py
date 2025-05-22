from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

chrome_driver_path = r"C:\Users\nakabayashi-yugo\tools\chromedriver-win64\chromedriver.exe"

def test_entry(data):
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)

    try:
        driver.get("http://localhost:3000/user_entry")

        fill_user_form(driver, data)
        driver.find_element(By.XPATH, "//button[text()='新規登録']").click()

        # ✅ アラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())

        # ✅ アラート処理
        alert = driver.switch_to.alert
        print("アラート内容:", alert.text)
        alert.accept()

        time.sleep(1)

        # 成功後の画面の文言確認（必要に応じて変更）
        assert "新規ユーザー登録" in driver.page_source

    finally:
        driver.quit()

def fill_user_form(driver, data):
    driver.find_element(By.NAME, "user-name").send_keys(data.get("user_name",""))
    driver.find_element(By.NAME, "password").send_keys(data.get("password", ""))

if __name__ == "__main__":
    test_data_list = [
        {"user_name": "", "password": "password"},
        {"user_name": "bayashi", "password": "password"},
        {"user_name": "山田", "password": ""},
        {"user_name": "山田", "password": "passwd"},
    ]

    for i, data in enumerate(test_data_list):
        print(f"\n▶ テストケース {i+1} 開始")
        test_entry(data)
