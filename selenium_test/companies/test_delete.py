from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import Select
import time

chrome_driver_path = r"C:\Users\nakabayashi-yugo\tools\chromedriver-win64\chromedriver.exe"

def test_delete(data):
    service = Service(executable_path=chrome_driver_path)
    driver = webdriver.Chrome(service=service)
    login(driver)

    try:
        driver.get("http://localhost:3000/cust_entry")

        # 会社一覧ボタンを押す(モーダル画面開く)
        driver.find_element(By.XPATH, "//button[text()='会社一覧']").click()

        # モーダル画面開くまで最大10秒待つ
        WebDriverWait(driver, 10).until(
            EC.visibility_of_element_located((By.XPATH, "//button[text()='会社登録']"))
        )

        # 名前にマッチする行が表示されたら削除ボタンを押す
        name_cell_xpath = f"//td[text()='{data['company_name']}']"
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, name_cell_xpath))
        )

        # 削除対象の削除ボタンを押す
        target_xpath = f"//tr[td[text()='{data['company_name']}']]//button[text()='削除']"
        delete_button = WebDriverWait(driver, 10).until(
            EC.element_to_be_clickable((By.XPATH, target_xpath))
        )
        delete_button.click()

        # 削除確認のアラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())
        time.sleep(1)
        # 削除確認のアラートに対しOKを押す
        try:
            alert = driver.switch_to.alert
            alert.accept()
        except:
            print("⚠️ アラートが見つかりませんでした")

        # ✅ アラートが出るまで最大10秒待つ
        WebDriverWait(driver, 10).until(EC.alert_is_present())

        time.sleep(1)

        isSuccess = False;
        # ✅ アラート処理
        try:
            alert = driver.switch_to.alert
            print("アラート内容:", alert.text)
            if "削除に成功" in alert.text:
                isSuccess = True
            print("成功しましたか？：", isSuccess)
            alert.accept()
        except:
            print("⚠️ アラートが見つかりませんでした")

        time.sleep(2)

        # 削除した対象の名前が表示されていなければok
        if isSuccess:
            WebDriverWait(driver, 10).until_not(
                EC.presence_of_element_located((By.XPATH, f"//td[text()='{data['company_name']}']"))
            )
        else:
            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.XPATH, f"//td[text()='{data['company_name']}']"))
            )


    finally:
        driver.quit()


def login(driver):
    driver.get("http://localhost:3000/user_login")
    driver.find_element(By.NAME, "user-name").send_keys("nakabayashi")
    driver.find_element(By.NAME, "password").send_keys("nakabayashi2025")
    driver.find_element(By.XPATH, "//button[text()='ログイン']").click()
    WebDriverWait(driver, 5).until(EC.alert_is_present())
    driver.switch_to.alert.accept()

if __name__ == "__main__":
    test_data_list = [
        {"company_name": "株式会社あおぞらマーケティング"},
        {"company_name": "株式会社モチゴメダイスキマン"},
        {"company_name": "株式会社ジェネレート996"},
        {"company_name": "a"},
    ]

    for i, data in enumerate(test_data_list):
        print(f"\n▶ テストケース {i+1} 開始")
        test_delete(data)
